<?php

namespace Database\Seeders;
use App\Models\allowed_foods;
use Uuid;

use Illuminate\Database\Seeder;

class AllowedFoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Leche Descremada';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Leche semidescremada';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Queso panela';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Queso cottage';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Huevo en cualquier presentación';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Frutas natuales';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Verduras naturales';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Aceite de cartamo';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Aceite de ajonjoli';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Aceite de jirasol';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Aceite de maiz';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Gelatina de agua sin azucar';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Té';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Café descafeinado';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Consome desgrasado';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Agua hervida de jamaica';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Agua de tamarindo';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Agua de limon';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Agua natural';
        $allowed->save();

        $allowed = new allowed_foods();
        $allowed->uuid = Uuid::generate()->string;
        $allowed->name = 'Jugo de Frutas';
        $allowed->save();
    }
}
