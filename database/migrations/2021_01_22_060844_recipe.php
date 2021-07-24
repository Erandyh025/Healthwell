<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Recipe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mongodb')->create('recipe', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('prescription');
            $table->date('start_date');
            $table->date('ending_date');
            $table->integer('inquiries_id')->unsigned();
            $table->foreign('inquiries_id')->references('id')->on('inquiries');
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
