<?php

namespace Database\Seeders;
use App\Models\Roles;
use Uuid;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Roles();
        $role->_id = 1;
        $role->uuid = Uuid::generate()->string;
        $role->name = 'Admin';
        $role->description = 'Tendra acceso a todo el sistema';

        $role->save();

     $role = new Roles();
        $role->_id = 2;
        $role->uuid = Uuid::generate()->string;
        $role->name = 'Doctor';
        $role->description = 'Tendra los permisos necesarios en la aplicacion web';

        $role->save();


        $role = new Roles();
        $role->_id = 3;
        $role->uuid = Uuid::generate()->string;
        $role->name = 'Paciente';
        $role->description = 'Tendra los permisos necesarios para acceder a la aplicacion movil';

        $role->save();
    }
}
