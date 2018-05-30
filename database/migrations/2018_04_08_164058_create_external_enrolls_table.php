<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExternalEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('external_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supervisor_id',15)->index();
            $table->integer('semester_id')->unsigned()->index();
            $table->integer('course_id')->unsigned()->index();
            $table->integer('exam_time_id')->unsigned()->index();
            $table->string('teacher_id',15)->index();
            $table->timestamps();

            $table->foreign('supervisor_id')->references('user_id')->on('users');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('teacher_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('external_enrolls');
    }
}
