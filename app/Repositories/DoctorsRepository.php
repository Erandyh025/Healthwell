<?php

namespace App\Repositories;

use App\Models\Doctors;
use App\Models\Persons;
use DB;


class DoctorsRepository
{
    public function create($uuid, $id_card, $specialty, $sub_especialty, $consulting_room, $hospitals_id, $persons_id)
    {
        $data['uuid'] = $uuid;
        $data['id_card'] = $id_card;
        $data['specialty'] = $specialty;
        $data['sub_especialty'] = $sub_especialty;
        $data['consulting_room'] = $consulting_room;
        $data['hospitals_id'] = $hospitals_id;
        $data['persons_id'] = $persons_id;
        return Doctors::create($data);

    }

    public function update($uuid, $id_card, $specialty, $sub_especialty, $consulting_room, $hospitals_id)
    {
        $doctors = $this->find($uuid);
        $doctors->id_card = $id_card;
        $doctors->specialty = $specialty;
        $doctors->sub_especialty = $sub_especialty;
        $doctors->consulting_room = $consulting_room;
        $doctors->hospitals_id = $hospitals_id;
        $doctors->save();
        return $doctors;

    }

    public function find($uuid)
    {
        return Doctors::where('uuid', '=', $uuid)->first();
    }

    function list() {
        $doctors = Doctors::with('persons')->get();
        return $doctors->toArray();
    }
    public function delete($uuid)
    {
        $doctors = $this->find($uuid);
        return $doctors->delete();
    }
    public function count(){
        return $doctors = DB::table('users')->where('roles_id', '=', 2)->count();
     }

}
