<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Domicile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('domicile', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->varchar('type'); 
            $table->varchar('street');
            $table->integer('number_ext'); 
            $table->integer('number_int'); 
            $table->varchar('state');
            $table->varchar('municipality'); 
            $table->varchar('location');
            $table->varchar('colony');
            $table->varchar('postalCode'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
