<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ScheduleAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('shedule_appointment', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->timestamps('date'); 
            $table->string('turn');
            $table->integer('patients_id')->unsigned();
            $table->foreign('patients_id')->references('id')->on('patients');
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
