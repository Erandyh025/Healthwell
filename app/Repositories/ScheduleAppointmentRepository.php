<?php

namespace App\Repositories;

use App\Models\Schedule_appointment;

class ScheduleAppointmentRepository
{
    public function create($uuid, $date, $turn, $patients_id)
    {
        $data['uuid'] = $uuid;
        $data['date'] = $date;
        $data['turn'] = $turn;
        $data['patients_id'] = $patients_id;
        return Schedule_appointment::create($data);

    }

    public function all()
    {
        return Schedule_appointment::all();
    }
    public function updated($uuid, $date, $turn, $patients_id)
    {
        $shedule = $this->find($uuid);
        $shedule->date = $date;
        $shedule->turn = $turn;
        $shedule->patients_id = $patients_id;
        $shedule->save();
        return $shedule;

    }

    public function delete($uuid)
    {
        $shedule = $this->find($uuid);
        return $shedule->delete();
    }
    function list() {
        return Schedule_appointment::all();
    }
    public function find($uuid)
    {
        return Schedule_appointment::where('uuid', '=', $uuid)->first();
    }

}
