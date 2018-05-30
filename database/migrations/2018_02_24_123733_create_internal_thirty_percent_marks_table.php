<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInternalThirtyPercentMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_thirty_percent_marks', function (Blueprint $table) {

            $table->increments('id');
            $table->string('teacher_id',15)->index();
            $table->integer('student_id')->unsigned();
            $table->integer('course_id')->unsigned()->index();
            $table->integer('exam_time_id')->unsigned();
            $table->integer('semester_id')->unsigned()->index();
            $table->decimal('tutorial_1',4,2);
            $table->decimal('tutorial_2',4,2);
            $table->decimal('tutorial_3',4,2);
            $table->tinyInteger('prefer_tutorial_id');
            $table->decimal('prefer_tutorial',4,2);
            $table->decimal('mid_term',4,2);
            $table->decimal('attendance',4,2);
            $table->decimal('total',4,2);
            $table->timestamps();

            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('course_id')->references('id')->on('courses');
            //$table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('teacher_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('internal_thirty_percent_marks');
    }
}
