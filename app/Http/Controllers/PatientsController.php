<?php

namespace App\Http\Controllers;

use App\Models\inquiries;
use App\Models\Patients;
use App\Models\Persons;
use App\Models\Roles;
use App\Models\User;
use App\Repositories\PatientsRepository;
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

class PatientsController extends Controller
{
    protected $patients_respository;
    protected $users_repository;
    protected $persons_repository;

    public function __construct(UsersRepository $_users, PersonsRepository $_persons, PatientsRepository $repository)
    {
        $this->users_repository = $_users;
        $this->persons_repository = $_persons;
        $this->patients_respository = $repository;
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
            'living_place' => 'required|string|max:30',
            'blood_type' => 'required|string|max:50',
            'disability' => 'required|string|max:50',
            'ethnic_group' => 'required|string|max:50',
            'religion' => 'required|string|max:50',
            'socioeconomic_level' => 'required|string|max:50',
            'age' => 'required|integer',

        ]);
        if ($validator->fails()) {
        //     Log::warning('PatientsController','create','Falta un campo por llenar');
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
            $person->id, User::PATIENTS);

        $patients = $this->patients_respository->create(Uuid::generate()->string, $request->get('living_place'), $request->get('blood_type'),
            $request->get('disability'), $request->get('ethnic_group'), $request->get('religion'), $request->get('socioeconomic_level'),
            $request->get('age'), $request->get('hospitals_id'), $person->id);

        $token = JWTAuth::fromUser($user);
        $this->sendEmail($user);

     //   Log::info('PatientsController - create - Se creo un nuevo paciente');
        return response()->json(compact('user', 'token', 'person', 'patients'), 201);
    } catch (\Exception $ex) {
        Log::emergency('PatientsController','create','Ocurrio un error al intentar crear un nuevo paciente');
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
            'living_place' => 'required|string|max:30',
            'blood_type' => 'required|string|max:50',
            'disability' => 'required|string|max:50',
            'ethnic_group' => 'required|string|max:50',
            'religion' => 'required|string|max:50',
            'socioeconomic_level' => 'required|string|max:50',
            'age' => 'required|integer',

        ]);
        if ($validator->fails()) {
            Log::warning('PatientsController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $user2 = User::where('uuid', '=', $uuid)->first();

        $patients = $this->patients_respository->update($user2->persons->patients->uuid, $request->get('living_place'), $request->get('blood_type'),
            $request->get('disability'), $request->get('ethnic_group'), $request->get('religion'), $request->get('socioeconomic_level'),
            $request->get('age'), $request->get('hospitals_id'));

        $person = $this->persons_repository->update($user2->persons->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'), $request->get('curp'), $request->get('cell_phone'),
            $request->get('telefone'), $request->get('photo'));

        $user = $this->users_repository->update($user2->uuid, $request->get('name'), $request->get('ap_patern'),
            $request->get('ap_matern'));

        Log::info('PatientsController - updated - Se actualizo un paciente con el uuid'.$this->hospitals_respository->find($uuid));
        return response()->json(compact('user', 'person', 'patients'), 201);
        } catch(\Exception $ex){
        Log::emergency('PatientsController','updated','Ocurrio un error al actualizar un paciente');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function retornarPatients($uuid){
        $user = User::withTrashed()->where('uuid', $uuid)->first();
        $user = $user->persons_id;
       $user_restore = User::withTrashed()->where('persons_id', $user)->restore();
      $patients = Patients::withTrashed()->where('persons_id', $user)->restore();
      $persons = Persons::withTrashed()->where('_id', $user)->restore();;     
   
       return response()->json('Usuario desbloqueado');
    }
    public function delete($uuid)
    {
        try{
        $user = User::where('uuid', '=', $uuid)->first();
        $user->persons->patients->delete();
        $user->persons->delete();
        $user->delete();

        Log::info('PatientsController - delete - se ha eliminado un paciente');
        return response()->json('Datos eliminados');
        } catch(\Exception $ex){
        Log::emergency('PatientsController','delete','Ocurrio un error al eliminar un paciente');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }
    
  public function list() {
        $persons = User::where('roles_id', '=', 3)->get();
        $patients = [];
        foreach($persons as $key => $value){
            $patients[$key] = [
                'id'=>$value['id'],
                'uuid'=>$value['uuid'],
                'paciente'=>$value['name'],
                'email'=>$value['email'],
                'name'=>$value->roles->name,
                'curp'=>$value->persons->curp,
                'patients_id'=>$value->persons->patients->_id,

            ];
        }
        return response()->json($patients);
    
    }
    public function PatientsBloquers(){
        $persons = User::where('roles_id', '=', 3)->onlyTrashed()->get();
        $patients = [];
        foreach($persons as $key => $value){
            $patients[$key] = [
                'id'=>$value['id'],
                'uuid'=>$value['uuid'],
                'paciente'=>$value['name'],
                'email'=>$value['email'],
                'name'=>$value->roles->name,

            ];
        }
        return response()->json($patients);
    } 

   /* public function editar($uuid)
    {

        $person = Persons::where('uuid', '=', $uuid)->first();
        $user = User::where('uuid', '=', $person->users->uuid)->first();
        $rol = Roles::where('uuid', '=', $user->roles->uuid)->first();
        $patients = Patients::where('uuid', '=', $person->patients->uuid)->first();
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
            'living_place' => $patients['living_place'],
            'blood_type' => $patients['blood_type'],
            'disability' => $patients['disability'],
            'ethnic_group' => $patients['ethnic_group'],
            'religion' => $patients['religion'],
            'socioeconomic_level' => $patients['socioeconomic_level'],
            'age' => $patients['age'],
            'hospitals_id' => $patients['hospitals_id'],
            // 'patients_id' => $inquiries['patients_id'],
            // 'inquiries_id' => $inquiries['id'],

            'rol' => $rol['name'],
        ];

        return response()->json($masvar);
    }
*/
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
        \Storage::disk('pacientes')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );

        Log::info('PatientsController - upload - Se ha subido nueva imagen');
        return response()->json($data, $data['code']);
    }
    public function return_image($name)
    {
        $imagen = \Storage::disk('pacientes')->exists($name);

        if ($imagen) {
            $file = \Storage::disk('pacientes')->get($name);
            return new Response($file, 201);
        } else {
            return response()->json('No existe la imagen');

        }
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
    public function count() {
        return response()->json($this->patients_respository->count());
    }
    public function listtratamient() {
        return response()->json($this->patients_respository->list());
    }
}
