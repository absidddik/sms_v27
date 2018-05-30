<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('student_id')->unsigned();
            $table->string('supervisor_id',15);
            $table->integer('batch_id')->unsigned();
            $table->integer('semester_id')->unsigned();
            $table->timestamps();

            $table->foreign('batch_id')->references('id')->on('batches');
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
        Schema::dropIfExists('student_enrolls');
    }
}
