<?php

namespace App\Repositories;

use App\Models\Patients;
use App\Models\Persons;

use DB;

class PatientsRepository
{
    public function create($uuid, $living_place, $blood_type, $disability, $ethnic_group, $religion, $socioeconomic_level, $age,
        $hospitals_id, $persons_id) {
        $data['uuid'] = $uuid;
        $data['living_place'] = $living_place;
        $data['blood_type'] = $blood_type;
        $data['disability'] = $disability;
        $data['ethnic_group'] = $ethnic_group;
        $data['religion'] = $religion;
        $data['socioeconomic_level'] = $socioeconomic_level;
        $data['age'] = $age;
        $data['hospitals_id'] = $hospitals_id;
        $data['persons_id'] = $persons_id;
        return Patients::create($data);

    }

    public function update($uuid, $living_place, $blood_type, $disability, $ethnic_group, $religion, $socioeconomic_level, $age,
        $hospitals_id) {

        $patients = $this->find($uuid);
        $patients->living_place = $living_place;
        $patients->blood_type = $blood_type;
        $patients->disability = $disability;
        $patients->ethnic_group = $ethnic_group;
        $patients->religion = $religion;
        $patients->socioeconomic_level = $socioeconomic_level;
        $patients->age = $age;
        $patients->hospitals_id = $hospitals_id;
        $patients->save();
        return $patients;

    }

    public function delete($uuid)
    {
        $patients = $this->find($uuid);
        return $patients->delete();
    }
    function list() {
        $patients = Patients::with('persons', 'inquiries')->get();
        return $patients->toArray();
    }
    public function find($uuid)
    {
        return Patients::where('uuid', '=', $uuid)->first();
    }

    public function count(){
        return $patients = DB::table('patients')->count();
     }
}
