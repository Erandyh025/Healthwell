<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->integer('num_inquirie');
            $table->boolean('tratamiento');
            $table->integer('patients_id')->unsigned();
            $table->foreign('patients_id')->references('id')->on('patients');
            $table->integer('doctors_id')->unsigned();
            $table->foreign('doctors_id')->references('id')->on('doctors');
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
        Schema::dropIfExists('inquiries');
    }
}
