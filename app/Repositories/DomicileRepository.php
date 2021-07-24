<?php

namespace App\Repositories;

use App\Models\Domicile;

class DomicileRepository
{
    public function create($uuid, $type, $street, $number_ext, $number_int, $state, $municipality, $colony, $postalCode, $persons_id)
    {
        $data['uuid'] = $uuid;
        $data['type'] = $type;
        $data['street'] = $street;
        $data['number_ext'] = $number_ext;
        $data['number_int'] = $number_int;
        $data['state'] = $state;
        $data['municipality'] = $municipality;
        $data['colony'] = $colony;
        $data['postalCode'] = $postalCode;
        $data['persons_id'] = $persons_id;

        return Domicile::create($data);

    }

    public function updated($uuid, $type, $street, $number_ext, $number_int, $state, $municipality, $colony, $postalCode,
        $persons_id) {
        $domicile = $this->find($uuid);
        $domicile->type = $type;
        $domicile->street = $street;
        $domicile->number_ext = $number_ext;
        $domicile->number_int = $number_int;
        $domicile->state = $state;
        $domicile->municipality = $municipality;
        $domicile->colony = $colony;
        $domicile->postalCode = $postalCode;
        $domicile->persons_id = $persons_id;
        $domicile->save();
        return $domicile;

    }

    public function delete($uuid)
    {
        $domicile = $this->find($uuid);
        return $domicile->delete();
    }
    public function find($uuid)
    {
        return Domicile::where('uuid', '=', $uuid)->first();
    }
    function list() {
        return Domicile::all();
    }
}
