<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Diet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('diet', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('allowed_foods_id')->unsigned();
            $table->integer('forbidden_foods_id')->unsigned();
            $table->integer('bread_and_substitute_id')->unsigned();
            $table->foreign('allowed_foods')->references('id')->on('allowed_foods');
            $table->foreign('forbidden_foods')->references('id')->on('forbidden_foods');
            $table->foreign('bread_and_substitute_id')->references('id')->on('bread_and_substitute');
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
