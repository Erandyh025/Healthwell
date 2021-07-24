<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BloodPressure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('blood_pressure', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('morning'); 
            $table->string('night');//->default('0/0'); //modificado
            $table->integer('persons_id')->unsigned();
            $table->foreign('persons_id')->references('id')->on('persons');
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
