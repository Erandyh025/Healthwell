<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Notes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->varchar('note'); 
            $table->integer('roles_id')->unsigned();
            $table->integer('persons_id')->unsigned();
            $table->foreign('roles_id')->references('id')->on('roles');
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
