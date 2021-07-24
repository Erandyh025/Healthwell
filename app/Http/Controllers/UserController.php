<?php

namespace App\Http\Controllers;

use App\Models\Doctors;
use App\Models\Persons;
use App\Models\User;
// use App\Models\Roles;
use App\Repositories\DoctorsRepository;
use App\Repositories\PersonsRepository;
use App\Repositories\UsersRepository;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Mail;
use Tymon\JWTAuth\Exceptions\JWTException;
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;




class UserController extends Controller
{

    protected $users_repository;
    protected $persons_repository;

    public function __construct(UsersRepository $_users, PersonsRepository $_persons) {
        $this->users_repository = $_users;
        $this->persons_repository = $_persons;

    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $users = JWTAuth::user()->with('roles')->first();
        // $rol = User::where('roles_id', '=', $users->roles->roles_id)->first();
        Log::info('UserController - authenticate - Se a inicado sesión'.$users);
        // if ($users->validation != '') {
        //     return response()->json('Por favor valide su usuario para poder logearse');
        // }

        return response()->json(compact('token', 'users'));
    }

    public function LoginGoogle(Request $request){
        $email = $request->get('email');
        try {
            if (!$email = User::where('email', '=', $email)->firts()) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (\Exception $ext) {
            return response()->json(['error' => $ext->getMessage()]);

        }

        $users = JWTAuth::user();
    //    $rol = User::where('roles_id', '=', $users->roles->roles_id)->first();
        Log::info('UserController - authenticate - Se a inicado sesión'.$users);
        if ($users->validation != '') {
            return response()->json('Por favor valide su usuario para poder logearse');
        }

        return response()->json(compact('users'));
    }
    public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException$e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException$e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException$e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        $rol = User::where('roles_id', '=', $user->roles->roles_id)->first(); //$user->roles->roles_id
        return response()->json(compact('user'));
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'ap_patern' => 'required|string|max:50',
            'ap_matern' => 'required|string|max:50',
            'curp' => 'required|string|unique:persons|max:18',
            'cell_phone' => 'required|string|max:10',
            'telefone' => 'required|string|max:10',
            'email' => 'required|string|unique:users|max:50',
            'password' => 'required|min:6|confirmed',
           
        ]);
        if ($validator->fails()) {
            //  Log::warning('UserController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        if ($request->isMethod('post')) {
            try {
                if ($request->file('photo') != null) {
                    $mime = "";
                    try {
                        $mime = $request->file('photo')->getMimeType();
                    } catch (\Exception$ex) {
                        return response()->json('No existe la imagen');
                    }
                    $name = strtolower($request->file('photo')->getClientOriginalName());
                    $name = str_replace(' ', '_', $name);
                    $path = public_path('images');
                    $request->file('imagen')->move($path, $name);
                } else {
                    $name = 'default.jpg';
                }
            } catch (\Exception$ext) {
                return response()->json('No existe la imagen');
            }
        }
        try{
       
        $person = $this->persons_repository->create(Uuid::generate()->string, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'), $request->get('curp'), $request->get('cell_phone'),
            $request->get('telefone'), $name);

        $user = $this->users_repository->create(Uuid::generate()->string, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'), $request->get('email'), Hash::make($request->get('password')),
            $request->get('validation') . substr($request->get('name'), 0, 3) . substr($request->get('email'), 0, 3) . '2021',
            $person->id, User::ADMIN);

            $token = JWTAuth::fromUser($user);
            $this->sendEmail($user);

    

        Log::info('UserController - create - Se creo un nuevo usuario');
        return response()->json(compact('user', 'token', 'person'), 201);
            }catch (\Exception $ex){
         Log::emergency('UserController','create','Ocurrio un error al crear un nuevo usuario');
        return response()->json(['error' => $ex->getMessage()]);
        }

    
    }
    function list() {
        $persons = User::where('roles_id', '=', 1)->get();
        $admins = [];
        foreach($persons as $key => $value){
            $admins[$key] = [
                'id'=>$value['id'],
                'uuid'=>$value['uuid'],
                'name'=>$value['name'],
                'email'=>$value['email'],
                'validation'=>$value['validation'],
                // 'roles_id'=>$value['roles_id'],
                'name'=>$value->roles->name, //El pedo esta aqui, tiene que ver con los roles
                'photo'=>$value->persons->photo,

            ];
        }
        return response()->json($admins);
    }

    public function delete($uuid)
    {
        try{
        $user = User::where('uuid', '=', $uuid)->first();
        $user->persons->delete();
        $user->delete();

        Log::info('UserController - delete - Se ha eliminado un usuario');
        return response()->json('Datos eliminados');
    } catch(\Exception $ex){
        Log::emergency('UserController','delete','Ocurrio un error al eliminar un usuario');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'ap_patern' => 'required|string|max:30',
            'ap_matern' => 'required|string|max:30',
            'curp' => 'required|string|max:18',
            'cell_phone' => 'required|string|max:10',
            'telefone' => 'required|string|max:10',

        ]);
        if ($validator->fails()) {
            // Log::warning('UserController','updated','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $user2 = User::where('uuid', '=', $uuid)->first();

        $person = $this->persons_repository->update($user2->persons->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'), $request->get('curp'), $request->get('cell_phone'),
            $request->get('telefone'), $request->get('photo'));

        $user = $this->users_repository->update($user2->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'));
        

            Log::info('UserController - updated - Se actualizo el usuario con el uuid'.$this->domicile_respository->find($uuid));
            return response()->json(compact('user', 'person', 'doctors'), 201);
        } catch(\Exception $ex){
            Log::emergency('UserController','updated','Ocurrio un error al actualizar un usuario');
            return response()->json(['error' => $ex->getMessage()]);
        }

    }
    public function validar(Request $request)
    {

        $users = User::where([['email', '=', $request->get('email')], ['validation', '=', $request->get('validar')]])->get();

        if (count($users) > 0) {
            $users[0]->validation = '';
            $users[0]->save();
        }
    }

    public function editar($uuid)
    {

        $user = User::where('uuid', '=', $uuid)->first();
        $person = Persons::where('uuid', '=', $user->persons->uuid)->first();
        // $doctors = Doctors::where('uuid', '=', $user->persons->doctors->uuid)->first();

        $masvar = [
            'id' => $person['id'],
            'uuid' => $user['uuid'],
            'name' => $person['name'],
            'ap_patern' => $person['ap_patern'],
            'ap_matern' => $person['ap_matern'],
            'curp' => $person['curp'],
            'cell_phone' => $person['cell_phone'],
            'telefone' => $person['telefone'],
            'photo' => $person['photo'],
            'roles_id' => $person['roles_id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'persons_id' => $user['persons_id'],

        ];

        return response()->json($masvar);
    }

    public function return_image($name)
    {
        $imagen = \Storage::disk('images')->exists($name);

        if ($imagen) {
            $file = \Storage::disk('images')->get($name);
            return new Response($file, 201);
        } else {
            return response()->json('No existe la imagen');

        }

    }

    public function upload(Request $request)
    {
        $image = $request->file('file0');

        $validator = Validator::make($request->all(), [

            'file0' => 'mimes:jpeg,jpg,png|required',

        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $image_name = time() . $image->getClientOriginalName();
        \Storage::disk('images')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );

        return response()->json($data, $data['code']);
    }
    public function sendEmail($user ){
        $datas['subject'] = 'HealthWell';
        $datas['for'] = $user['email'];
        Mail::send('mail.mail', ['user' => $user], function ($msj) use ($datas) {
            $msj->from("healthwellapp@gmail.com", "HealthWell");
            $msj->subject($datas['subject']);
            $msj->to($datas['for']);
        });
    }
}
