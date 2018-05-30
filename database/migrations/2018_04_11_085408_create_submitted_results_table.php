<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubmittedResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('submitted_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('teacher_id',15)->index();
            $table->integer('exam_time_id')->unsigned();
            $table->integer('course_id')->unsigned()->index();
            $table->integer('semester_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('teacher_id')->references('user_id')->on('users');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('semester_id')->references('id')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('submitted_results');
    }
}
