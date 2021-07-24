<?php

namespace App\Repositories;

use App\Models\Roles;

class RolesRepository
{

    function list() {
        return Roles::all();
    }

}
