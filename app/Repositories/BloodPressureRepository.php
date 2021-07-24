<?php

namespace App\Repositories;

use App\Models\Blood_pressure;

class BloodPressureRepository
{
    public function create($uuid, $morning, $night, $persons_id)
    {
        $data['uuid'] = $uuid;
        $data['morning'] = $morning;
        $data['night'] = $night;
        $data['persons_id'] = $persons_id;

        return Blood_pressure::create($data);

    }

    public function updated($uuid, $morning, $night, $persons_id)
    {
        $blood = $this->find($uuid);
        $blood->morning = $morning;
        $blood->night = $night;
        $blood->persons_id = $persons_id;
        $blood->save();
        return $blood;

    }

    public function delete($uuid)
    {
        $blood = $this->find($uuid);
        return $blood->delete();
    }
    
    public function find($uuid)
    {
        return Blood_pressure::where('uuid', '=', $uuid)->first();
    }
    function list() {
        return Blood_pressure::all();
    }
}
