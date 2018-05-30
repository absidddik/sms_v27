<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDueStudentEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('due_student_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('supervisor_id',15);
            $table->integer('exam_time_id')->unsigned();
            $table->integer('semester_id')->unsigned();
            $table->timestamps();

            $table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('semester_id')->references('id')->on('semesters');
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
        Schema::dropIfExists('due_student_enrolls');
    }
}
