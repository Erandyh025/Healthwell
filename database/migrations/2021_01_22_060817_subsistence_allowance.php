<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SubsistenceAllowance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('subsistence_allowance', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('allowedfoods_id')->unsigned();
            $table->foreign('allowedfoods_id')->references('id')->on('allowed_foods');
            $table->integer('forbiddenfoods_id')->unsigned();
            $table->foreign('forbiddenfoods_id')->references('id')->on('forbidden_foods');
            $table->integer('breadandsustitute_id')->unsigned();
            $table->foreign('breadandsustitute_id')->references('id')->on('bread_and_sustitute');
            $table->integer('patients_id')->unsigned();
            $table->foreign('patients_id')->references('id')->on('patients');
            $table->string('observer');
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
