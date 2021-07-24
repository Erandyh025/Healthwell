<?php

namespace App\Http\Controllers;

use App\Repositories\HospitalsRepository;
use File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;



class HospitalsController extends Controller
{
    protected $hospitals_respository;

    public function __construct(HospitalsRepository $repository)
    {
        $this->hospitals_respository = $repository;

    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'direction' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::warning('HospitalsController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $uuid = Uuid::generate()->string;
        $name = $request->input('name');
        $direction = $request->input('direction');
        $photo = $request->input('photo');
        Log::info('HospitalsController - create - Se creo un nuevo hospital');
        return response()->json($this->hospitals_respository->create($uuid, $name, $direction, $photo));
        } catch (\Exception $ex) {
            Log::emergency('HospitalsController','create','Ocurrio un error al crear un nuevo hospital');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }

    public function updated(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:30',
            'direction' => 'required|string|max:50',
        ]);
        if ($validator->fails()) {
            Log::warning('HospitalsController','updated','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $name = $request->input('name');
        $direction = $request->input('direction');
        $photo = $request->input('photo');
        Log::info('HospitalsController - updated - Se actualizo un hospital con el uuid'.$this->hospitals_respository->find($uuid));
        return response()->json($this->hospitals_respository->updated($uuid, $name, $direction, $photo));
        } catch(\Exception $ex){
            Log::emergency('HospitalsController','updated','Ocurrio un error al actualizar un hospital');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }

    public function delete($uuid)
    {
        try{
        Log::info('HospitalsController - delete - se ha eliminado un hospital');
        return response()->json($this->hospitals_respository->delete($uuid));
        } catch(\Exception $ex){
            Log::emergency('HospitalsController','delete','Ocurrio un error al eliminar un hospital');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->hospitals_respository->list());
    }

    public function editar($uuid)
    {
        return response()->json($this->hospitals_respository->find($uuid));
    }

    public function HospitalsCount(){
        return response()->json($this->hospitals_respository->HospitalsCount());
    }

    public function return_image($name)
    {
        $imagen = \Storage::disk('hospital')->exists($name);

        if ($imagen) {
            $file = \Storage::disk('hospital')->get($name);
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
            Log::warning('HospitalsController','upload','Verifique el formato de la imagen');
            return response()->json($validator->errors()->toJson(), 400);
        }

        $image_name = time() . $image->getClientOriginalName();
        \Storage::disk('hospital')->put($image_name, \File::get($image));
        $data = array(
            'code' => 200,
            'imagen' => $image_name,
            'status' => 'success',
        );
        Log::info('HospitalsController - upload - Se ha subido nueva imagen');
        return response()->json($data, $data['code']);
    }
}
