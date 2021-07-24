<?php

namespace Database\Seeders;
use App\Models\forbidden_foods;
use Uuid;

use Illuminate\Database\Seeder;

class ForbiddenFoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Carne de cerdo en general';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Tocino';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Chorizo';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Longaniza';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Moronga';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Higado';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Panza';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Sesos';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Mariscos en general';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Frutas secas en general';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Frutas cocidas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Frutas con azucar';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Frutas con miel';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Ensaladas en general';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Pan dulce';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Galletas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Jaleas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Bombon';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Pasteleria';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Reposteria';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Aceite de coco';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Manteca de cerdo';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Frituras';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Fritangas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Postres a base de leche';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Flanes';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Merengues';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Jaleas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Mieles';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Mermeladas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Cajetas';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Refrescos';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Refresco dietetico';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Bebidas alcoholicas';
        $forbidden->save();


        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Jugos';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Nectares';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Agua mineral';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Refrescos';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Jugos de carne';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Consome';
        $forbidden->save();



        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Comida empanizada';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Comida capeada';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Moles';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Pipianes';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Adobos';
        $forbidden->save();

        $forbidden = new forbidden_foods();
        $forbidden->uuid = Uuid::generate()->string;
        $forbidden->name = 'Comidas con cremas';
        $forbidden->save();
    }
}
