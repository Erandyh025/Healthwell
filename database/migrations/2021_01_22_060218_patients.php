<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Patients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('living_place'); 
            $table->string('blood_type'); 
            $table->string('disability'); 
            $table->string('ethnic_group'); 
            $table->string('religion'); 
            $table->string('socioeconomic_level'); 
            $table->integer('age');
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
