<?php

namespace App\Http\Controllers;

use App\Models\inquiries;
use App\Repositories\InquiriesRepository;
use Illuminate\Http\Request;
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class inquiriesController extends Controller
{
    protected $inquieries_respository;

    public function __construct(InquiriesRepository $repository)
    {
        $this->inquieries_respository = $repository;
    }

    public function create(Request $request)
    {
        try{
        $uuid = Uuid::generate()->string;
        $num_inquirie = $request->input('num_inquirie');
        $tratamiento = inquiries::TRATAMIENTO;
        $patients_id = $request->input('patients_id');
        $doctors_id = $request->input('doctors_id');
        Log::info('inquiriesController - create - Se creo una nueva consulta');
        return response()->json($this->inquieries_respository->create($uuid, $num_inquirie, $tratamiento, $patients_id, $doctors_id));
    } catch (\Exception $ex) {
        Log::emergency('inquiriesController','create','Ocurrio un error al crear una nueva consulta');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $uuid)
    {
        try{
        $num_inquirie = $request->input('num_inquirie');
        $patients_id = $request->input('patients_id');
        $doctors_id = $request->input('doctors_id');
        Log::info('inquiriesController - updated - Se actualizo la consulta con el uuid'.$this->inquieries_respository->find($uuid));
        return response()->json($this->inquieries_respository->update($uuid, $num_inquirie, $patients_id, $doctors_id));
    } catch(\Exception $ex){
        Log::emergency('inquiriesController','updated','Ocurrio un error al actualizar una consulta');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function delete($uuid)
    {
        try{
            Log::info('inquiriesController - delete - se ha eliminado ua consulta');
            return response()->json($this->inquieries_respository->delete($uuid));
        } catch(\Exception $ex){
            Log::emergency('inquiriesController','delete','Ocurrio un error al eliminar una consulta');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->inquieries_respository->list());
    }

    public function editar($uuid)
    {
        return response()->json($this->inquieries_respository->find($uuid));
    }
    public function count(){
        return response()->json($this->inquieries_respository->count());
    }
}
