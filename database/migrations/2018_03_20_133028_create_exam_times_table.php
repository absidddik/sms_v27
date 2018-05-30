<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExamTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_times', function (Blueprint $table) {
            $table->increments('id');
            $table->string('exam_month');
            $table->string('exam_year');
            $table->string('slug');
            $table->string('supervisor_id',15)->index();
            $table->timestamps();

            $table->foreign('supervisor_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_times');
    }
}
