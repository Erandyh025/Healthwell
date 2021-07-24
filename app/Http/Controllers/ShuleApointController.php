<?php

namespace App\Http\Controllers;

use App\Models\Schedule_appointment;
use App\Repositories\ScheduleAppointmentRepository;
use Illuminate\Http\Request;
use Uuid;

use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class ShuleApointController extends Controller
{
    protected $shedule_appointment_respository;

    public function __construct(ScheduleAppointmentRepository $repository)
    {
        $this->shedule_appointment_respository = $repository;
    }

    public function create(Request $request)
    {
        try{
        $uuid = Uuid::generate()->string;
        $date = $request->input('date');
        $turn = $request->input('turn');
        $patients_id = $request->input('patients_id');
        Log::info('ShuleApointController - create - Se creo una nueva cita');
        return response()->json($this->shedule_appointment_respository->create($uuid, $date, $turn, $patients_id));
        } catch (\Exception $ex) {
        Log::emergency('ShuleApointController','create','Ocurrio un error al crear una nueva cita');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $uuid)
    {
        try{
        $date = $request->input('date');
        $turn = $request->input('turn');
        $patients_id = $request->input('patients_id');
        Log::info('ShuleApointController - updated - Se actualizo una cita con el uuid'.$this->hospitals_respository->find($uuid));
        return response()->json($this->shedule_appointment_respository->updated($uuid, $date, $turn, $patients_id));
        } catch(\Exception $ex){
        Log::emergency('ShuleApointController','updated','Ocurrio un error al actualizar la cita');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }
    public function delete($uuid)
    {
        try{
            Log::info('ShuleApointController - delete - se ha eliminado una cita');
            return response()->json($this->shedule_appointment_respository->delete($uuid));
            } catch(\Exception $ex){
                Log::emergency('ShuleApointController','delete','Ocurrio un error al eliminar una cita');
                return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->shedule_appointment_respository->list());
    }

    public function editar($uuid)
    {
        $otraVar = Schedule_appointment::where('uuid', '=', $uuid)->first();
        $masvar = [
            'id' => $otraVar['id'],
            'date' => $otraVar['date'],
            'turn' => $otraVar['turn'],
            'patients_id' => $otraVar['patients_id'],
        ];
        return response()->json($masvar);
    }
}
