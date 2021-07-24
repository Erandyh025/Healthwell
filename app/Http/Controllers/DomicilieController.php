<?php

namespace App\Http\Controllers;

use App\Repositories\DomicileRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Uuid;

use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class DomicilieController extends Controller
{
    protected $domicile_respository;

    public function __construct(DomicileRepository $repository)
    {
        $this->domicile_respository = $repository;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:30',
            'street' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'municipality' => 'required|string|max:50',
            'colony' => 'required|string|max:50',
            'postalCode' => 'required|digits:5|integer',

        ]);
        if ($validator->fails()) {
            Log::warning('DomicilieController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $uuid = Uuid::generate()->string;
        $type = $request->input('type');
        $street = $request->input('street');
        $number_ext = $request->input('number_ext');
        $number_int = $request->input('number_int');
        $state = $request->input('state');
        $municipality = $request->input('municipality');
        $colony = $request->input('colony');
        $postalCode = $request->input('postalCode');
        $persons_id = $request->input('persons_id');
        Log::info('DomicilieController - create - Se creo un nuevo domicilio');
        return response()->json($this->domicile_respository->create($uuid, $type, $street, $number_ext, $number_int,
            $state, $municipality, $colony, $postalCode, $persons_id));
        } catch (\Exception $ex){
            Log::emergency('DomicilieController','create','Ocurrio un error al crear un nuevo domicilio');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }

    public function updated(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|max:30',
            'street' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'municipality' => 'required|string|max:50',
            'colony' => 'required|string|max:50',
            'postalCode' => 'required|digits:5|integer',

        ]);
        if ($validator->fails()) {
            Log::warning('DomicilieController','updated','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $type = $request->input('type');
        $street = $request->input('street');
        $number_ext = $request->input('number_ext');
        $number_int = $request->input('number_int');
        $state = $request->input('state');
        $municipality = $request->input('municipality');
        $colony = $request->input('colony');
        $postalCode = $request->input('postalCode');
        $persons_id = $request->input('persons_id');
        Log::info('DomicilieController - updated - Se actualizo el domicilio con el uuid'.$this->domicile_respository->find($uuid));
        return response()->json($this->domicile_respository->updated($uuid, $type, $street, $number_ext, $number_int,
            $state, $municipality, $colony, $postalCode, $persons_id));
        } catch(\Exception $ex){
            Log::emergency('DomicilieController','updated','Ocurrio un error al actualizar un domicilio');
            return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function delete($uuid)
    {
        try{
            Log::info('DomicilieController - delete - Se ha eliminado un domicilio');
            return response()->json($this->domicile_respository->delete($uuid));
        } catch(\Exception $ex){
            Log::emergency('DomicilieController','delete','Ocurrio un error al eliminar un domicilio');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->domicile_respository->list());
    }

    public function editar($uuid)
    {
        return response()->json($this->domicile_respository->find($uuid));
    }

}
