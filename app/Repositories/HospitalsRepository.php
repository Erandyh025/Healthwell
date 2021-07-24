<?php

namespace App\Repositories;

use App\Models\Hospitals;
use DB;

class HospitalsRepository
{
    public function create($uuid, $name, $direction, $photo)
    {

        $hospitals['uuid'] = $uuid;
        $hospitals['name'] = $name;
        $hospitals['direction'] = $direction;
        $hospitals['photo'] = $photo;
        return Hospitals::create($hospitals);

    }

    public function updated($uuid, $name, $direction, $photo)
    {
        $hospitals = $this->find($uuid);
        $hospitals->name = $name;
        $hospitals->direction = $direction;
        $hospitals->photo = $photo;
        $hospitals->save();
        return $hospitals;

    }

    public function delete($uuid)
    {
        $hospitals = $this->find($uuid);
        return $hospitals->delete();
    }
    function list() {
        return Hospitals::all();
    }
    public function find($uuid)
    {
        return Hospitals::where('uuid', '=', $uuid)->first();
    }
    public function HospitalsCount(){
        $hospitals = DB::table('hospitals')->count();
        return $hospitals;
    }
}
