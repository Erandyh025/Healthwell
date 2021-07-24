<?php

namespace App\Http\Controllers;

use App\Models\inquiries;
use App\Models\Doctors;
use App\Models\Persons;
use App\Models\Roles;
use App\Models\User;
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
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class DoctorsController extends Controller
{
    protected $doctors_repository;
    protected $users_repository;
    protected $persons_repository;

    public function __construct(UsersRepository $_users, PersonsRepository $_persons, DoctorsRepository $_doctors)
    {
        $this->users_repository = $_users;
        $this->persons_repository = $_persons;
        $this->doctors_repository = $_doctors;
    }

    public function create(Request $request)
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
            'id_card' => 'required|string',
            'specialty' => 'required|string',
            'sub_especialty' => 'required|string',
            'consulting_room' => 'required|string',

        ]);
        if ($validator->fails()) {
            Log::warning('DoctorsController','create','Falta un campo por llenar');
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
            $request->get('validation') . substr($request->get('name'), 0, 3) . substr($request->get('email'), 0, 3) . '2020',
            $person->id,User::DOCTORS);

        $doctors = $this->doctors_repository->create(Uuid::generate()->string, $request->get('id_card'), $request->get('specialty'),
            $request->get('sub_especialty'), $request->get('consulting_room'), $request->get('hospitals_id'), $person->id);


        $token = JWTAuth::fromUser($user);
        $this->sendEmail($user);
        
        Log::info('DoctorsController - create - Se creo un nuevo paciente');
        return response()->json(compact('user', 'token', 'person', 'doctors'), 201);
    } catch (\Exception $ex) {
        Log::emergency('DoctorsController','create','Ocurrio un error al intentar crear un nuevo doctor');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

//agregar id de domicilio
    public function updated(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'ap_patern' => 'required|string|max:50',
            'ap_matern' => 'required|string|max:50',
            'curp' => 'required|string|max:18',
            'cell_phone' => 'required|string|max:10',
            'telefone' => 'required|string|max:10',
            'id_card' => 'required|string',
            'specialty' => 'required|string',
            'sub_especialty' => 'required|string',
            'consulting_room' => 'required|string',

        ]);
        if ($validator->fails()) {
            Log::warning('DoctorsController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $user2 = User::where('uuid', '=', $uuid)->first();

        $doctors = $this->doctors_repository->create(Uuid::generate()->string, $request->get('id_card'), $request->get('specialty'),
        $request->get('sub_especialty'), $request->get('consulting_room'), $request->get('hospitals_id'), $person->id);
      
        $person = $this->persons_repository->update($user2->persons->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'), $request->get('curp'), $request->get('cell_phone'),
            $request->get('telefone'), $request->get('photo'));

        $user = $this->users_repository->update($user2->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'));

        Log::info('DoctorsController - updated - Se actualizo un paciente con el uuid'.$this->hospitals_respository->find($uuid));
        return response()->json(compact('user', 'person', 'doctors'), 201);
        } catch(\Exception $ex){
        Log::emergency('DoctorsController','updated','Ocurrio un error al actualizar un paciente');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function editar($uuid)
    {

        $person = Persons::where('uuid', '=', $uuid)->first();
        $user = User::where('uuid', '=', $person->users->uuid)->first();
        $rol = Roles::where('uuid', '=', $user->roles->uuid)->first();
        $doctors = Doctors::where('uuid', '=', $person->doctors->uuid)->firts();
        // $patients = Patients::where('uuid', '=', $person->patients->uuid)->first();
        // $inquiries = inquiries::where('uuid', '=', $patients->inquiries->uuid)->first();

        $masvar = [
            'id' => $person['id'],
            'uuid' => $user['uuid'],
            'person' => $person['name'],
            'ap_patern' => $person['ap_patern'],
            'ap_matern' => $person['ap_matern'],
            'curp' => $person['curp'],
            'cell_phone' => $person['cell_phone'],
            'telefone' => $person['telefone'],
            'photo' => $person['photo'],
            'roles_id' => $user['roles_id'],
            'email' => $user['email'],
            'name' => $user['name'],
            'persons_id' => $user['persons_id'],
            'id_card' => $doctors['id_card'],
            'specialty' => $doctors['specialty'],
            'sub_especialty' => $doctors['sub_especialty'],
            'consulting_room' => $doctors['consulting_room'],
            'hospitals_id' => $doctors['hospitals_id'],
            'persons_id' => $doctors['persons_id'],

            'rol' => $rol['name'],
        ];

        return response()->json($masvar);
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
        \Storage::disk('doctors')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );

        Log::info('DoctorsController - upload - Se ha subido nueva imagen');
        return response()->json($data, $data['code']);
    }
    public function return_image($name)
    {
        $imagen = \Storage::disk('doctors')->exists($name);

        if ($imagen) {
            $file = \Storage::disk('doctors')->get($name);
            return new Response($file, 201);
        } else {
            return response()->json('No existe la imagen');

        }
    }
   public function list() {
        $persons = User::where('roles_id', '=', 2)->get();
        $doctors = [];
        foreach($persons as $key => $value){
            $doctors[$key] = [
                'id'=>$value['_id'],
                'uuid'=>$value['uuid'],
                'doctor'=>$value['name'],
                'email'=>$value['email'],
                'name'=>$value->roles->name,

            ];
        }
        return response()->json($doctors);
    }    
    public function DoctorsBloquers(){
        $persons = User::where('roles_id', '=', 2)->onlyTrashed()->get();
        $doctors = [];
        foreach($persons as $key => $value){
            $doctors[$key] = [
                'id'=>$value['id'],
                'uuid'=>$value['uuid'],
                'doctor'=>$value['name'],
                'email'=>$value['email'],
                'name'=>$value->roles->name,

            ];
        }
        return response()->json($doctors);
    }  
    public function retornarDoctor($uuid){
        $user = User::withTrashed()->where('uuid', $uuid)->first();
        $user = $user->persons_id;
       $user_restore = User::withTrashed()->where('persons_id', $user)->restore();
      $doctors = Doctors::withTrashed()->where('persons_id', $user)->restore();
      $persons = Persons::withTrashed()->where('_id', $user)->restore();;     
   
       return response()->json('Usuario desbloqueado');
    }
    public function delete($uuid)
    {
        $user = User::where('uuid', '=', $uuid)->first();
        $user->persons->doctors->delete();
        $user->persons->delete();
        $user->delete();

        return response()->json('usuario bloqueado');
   
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
    public function count(){
        return response()->json($this->doctors_repository->count());
    }
}
