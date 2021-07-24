<?php

namespace App\Http\Controllers;

use App\Repositories\RolesRepository;

class RolesController extends Controller
{
    protected $roles_respository;

    public function __construct(RolesRepository $repository)
    {
        $this->roles_respository = $repository;
    }

    function list() {
        return response()->json($this->roles_respository->list());
    }

}
