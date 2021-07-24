<?php

namespace App\Repositories;

use App\Models\User;

// 
use DB;
// 

class UsersRepository
{
    public function create($uuid, $name, $ap_patern, $ap_matern, $email, $password, $validation, $persons_id, $roles_id)
    {
        $user['uuid'] = $uuid;
        $user['name'] = $name . ' ' . $ap_patern . ' ' . $ap_matern;
        $user['email'] = $email;
        $user['password'] = $password;
        $user['validation'] = $validation;
        $user['persons_id'] = $persons_id;
        $user['roles_id'] = $roles_id;

        return User::create($user);
    }
    public function update($uuid, $name, $ap_patern, $ap_matern)
    {
        $user = $this->find($uuid);
        $user->name = $name . ' ' . $ap_patern . ' ' . $ap_matern;
        $user->save();
        return $user;
    }

    public function find($uuid)
    {
        return User::where('uuid', '=', $uuid)->first();
    }

}
