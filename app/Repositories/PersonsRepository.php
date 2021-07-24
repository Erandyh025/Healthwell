<?php

namespace App\Repositories;

use App\Models\Persons;
use App\Models\User;

class PersonsRepository
{

    public function create($uuid, $name, $ap_patern, $ap_matern, $curp, $cell_phone, $telefone, $photo)
    {
        $person['uuid'] = $uuid;
        $person['name'] = $name;
        $person['ap_patern'] = $ap_patern;
        $person['ap_matern'] = $ap_matern;
        $person['curp'] = $curp;
        $person['cell_phone'] = $cell_phone;
        $person['telefone'] = $telefone;
        $person['photo'] = $photo;

        return Persons::create($person);
    }

    public function update($uuid, $name, $ap_patern, $ap_matern, $curp, $cell_phone, $telefone, $photo)
    {
        $person = $this->find($uuid);
        $person->name = $name;
        $person->ap_patern = $ap_patern;
        $person->ap_matern = $ap_matern;
        $person->curp = $curp;
        $person->cell_phone = $cell_phone;
        $person->telefone = $telefone;
        $person->photo = $photo;
        $person->save();
        return $person;
    }
    public function find($uuid)
    {
        return Persons::where('uuid', '=', $uuid)->first();
    }

    function list() {
        $persons = User::with('persons','roles')->get();
        return $persons->toArray();
    }


    // public function borrados(){
    //     $person = Persons::with('users')->onlyTrashed()->get();

    //     return $visitante->toArray();

    // }
}
