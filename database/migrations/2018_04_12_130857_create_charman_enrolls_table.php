<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCharmanEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('charman_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supervisor_id',15)->index();
            $table->integer('exam_time_id')->unsigned();
            $table->integer('semester_id')->unsigned();
            $table->string('charman_id',15)->index();
            $table->timestamps();

            $table->foreign('supervisor_id')->references('user_id')->on('users');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('charman_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('charman_enrolls');
    }
}
