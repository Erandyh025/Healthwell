<?php

namespace App\Repositories;

use App\Models\inquiries;
use DB;

class InquiriesRepository
{
    public function create($uuid, $num_inquirie, $tratamiento, $patients_id, $doctors_id)
    {
        $data['uuid'] = $uuid;
        $data['num_inquirie'] = $num_inquirie;
        $data['tratamiento'] = $tratamiento;
        $data['patients_id'] = $patients_id;
        $data['doctors_id'] = $doctors_id;
        return inquiries::create($data);

    }

    public function update($uuid, $num_inquirie, $patients_id, $doctors_id)
    {
        $inquiries = $this->find($uuid);
        $inquiries->num_inquirie = $num_inquirie;
        $inquiries->patients_id = $patients_id;
        $inquiries->doctors_id = $doctors_id;
        $inquiries->save();
        return $inquiries;

    }

    public function delete($uuid)
    {
        $inquiries = $this->find($uuid);
        return $inquiries->delete();
    }
    public function find($uuid)
    {
        return inquiries::where('uuid', '=', $uuid)->first();
    }

    function list() {
        $persons = inquiries::with('doctors', 'patients')->get();
        return $persons->toArray();
    }
    public function count(){
        return $patients = DB::table('inquiries')->where('tratamiento', '=', true)->count();
     }

}
