<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Doctors extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->varchar('id_card'); 
            $table->varchar('specialty'); 
            $table->varchar('sub_especialty');   
            $table->varchar('consulting_room'); 
            $table->integer('hospitals_id')->unsigned();
            $table->foreign('hospitals_id')->references('id')->on('hospitals');
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
