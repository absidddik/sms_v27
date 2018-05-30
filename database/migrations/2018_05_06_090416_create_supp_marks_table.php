<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuppMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supp_marks', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('teacher_id',15)->index();
            $table->integer('student_id')->unsigned();
            $table->integer('course_id')->unsigned()->index();
            $table->integer('exam_time_id')->unsigned()->index();
            $table->integer('semester_id')->unsigned()->index();

            $table->decimal('q_1',4,2);
            $table->decimal('q_2',4,2);
            $table->decimal('q_3',4,2);
            $table->decimal('q_4',4,2);
            $table->decimal('q_5',4,2);
            $table->decimal('q_6',4,2);
            $table->decimal('q_7',4,2);
            $table->decimal('q_8',4,2);
            $table->decimal('q_9',4,2);
            $table->decimal('q_10',4,2);
            $table->decimal('q_11',4,2);
            $table->decimal('q_12',4,2);
            $table->decimal('q_13',4,2);
            $table->decimal('q_14',4,2);
            $table->decimal('q_15',4,2);

            $table->decimal('total',4,2);

            $table->timestamps();

            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
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
        Schema::dropIfExists('supp_marks');
    }
}
