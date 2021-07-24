<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('persons', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name'); 
            $table->string('ap_patern');
            $table->string('ap_matern'); 
            $table->string('curp')->unique();
            $table->string('domicile');
            $table->string('cell_phone');
            $table->string('telefone');
            $table->string('photo');
            $table->integer('domicilie_id')->unsigned();
            $table->foreign('domicilie_id')->references('id')->on('domicilie_id');
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
