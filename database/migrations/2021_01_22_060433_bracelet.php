<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Bracelet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('bracelet', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->varchar('blood_oxygenation'); 
            $table->varchar('heart_rate'); 
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
