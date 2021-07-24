<?php

namespace Database\Seeders;
use App\Models\Bread_and_sustitute;
use Uuid;

use Illuminate\Database\Seeder;

class BreadAndSustituteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Bolillo';
        $bread->count = '1/3 pieza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Tortilla integral';
        $bread->count = '1 pieza';
        $bread->save();


        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Pan tostado';
        $bread->count = '1 pieza';
        $bread->save();



        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Arroz';
        $bread->count = '1/2 taza';
        $bread->save();


        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Avena';
        $bread->count = '1/2 taza';
        $bread->save();


        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Sopa de pasta';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Corn Flakes';
        $bread->count = '1/2 taza';
        $bread->save();


        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'All Bran';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Frijol';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Lenteja';
        $bread->count = '1/2 taza';
        $bread->save();


        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Alubia';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Garbanzo';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Haba';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Papa';
        $bread->count = '1 pieza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Camote';
        $bread->count = '1/3 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Elote';
        $bread->count = '1/2 taza';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Maizena';
        $bread->count = '3 cucharadas';
        $bread->save();

        $bread = new Bread_and_sustitute();
        $bread->uuid = Uuid::generate()->string;
        $bread->name = 'Harina de Arroz';
        $bread->count = '3 cucharadas';
        $bread->save();
    }
}
