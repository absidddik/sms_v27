<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supp_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('supervisor_id',15);
            $table->integer('batch_id')->unsigned();
            $table->integer('course_e_id')->unsigned();
            $table->tinyInteger('exam_type')->unsigned();
            $table->integer('exam_time_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches');
            $table->foreign('course_e_id')->references('id')->on('course_enrolls');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('supervisor_id')->references('user_id')->on('users');
            $table->foreign('student_id')->references('id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supp_enrolls');
    }
}
