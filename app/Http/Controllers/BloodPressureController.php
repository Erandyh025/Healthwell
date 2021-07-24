<?php

namespace App\Http\Controllers;

use App\Models\Blood_pressure;
use App\Repositories\BloodPressureRepository;
use Illuminate\Http\Request;
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class BloodPressureController extends Controller
{
    protected $bloodpressure_repository;

    public function __construct(BloodPressureRepository $repository)
    {
        $this->bloodpressure_repository = $repository;
    }

    public function create(Request $request)
    {
        try{
        $uuid = Uuid::generate()->string;
        $morning = $request->input('morning');
        $night = $request->input('night');
        $persons_id = $request->input('persons_id');
        Log::info('BloodPressureController - create - Presion arterial registrada');
        return response()->json($this->bloodpressure_repository->create($uuid, $morning, $night, $persons_id)); //quite el ning
        } catch (\Exception $ex) {
        Log::emergency('BloodPressureController','create','Ocurrio un error al intentar registrar la presión arterial');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $uuid)
    {
        try{
        $morning = $request->input('morning');
        $night = $request->input('night');
        $persons_id = $request->input('persons_id');
        Log::info('BloodPressureController - updated - Se actualizo la presión arterial con el uuid'.$this->bloodpressure_repository->find($uuid));
        return response()->json($this->bloodpressure_repository->updated($uuid, $morning, $night, $persons_id));
        } catch(\Exception $ex){
        Log::emergency('BloodPressureController','updated','Ocurrio un error al actualizar la presión arterial');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function delete($uuid)
    {
        try{
            Log::info('BloodPressureController - delete - Se ha eliminado la presión arterial');
            return response()->json($this->bloodpressure_repository->delete($uuid));
        } catch(\Exception $ex){
            Log::emergency('BloodPressureController','delete','Ocurrio un error al eliminar la presión arterial');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->bloodpressure_repository->list());
    }

    public function editar($uuid)
    {
        $otraVar = Blood_pressure::where('uuid', '=', $uuid)->first();
        $masvar = [
            'id' => $otraVar['id'],
            'morning' => $otraVar['morning'],
            'night' => $otraVar['night'],
            'persons_id' => $otraVar['persons_id'],
        ];
        return response()->json($masvar);
    }

}
