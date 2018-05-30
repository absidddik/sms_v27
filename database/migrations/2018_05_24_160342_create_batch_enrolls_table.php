<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBatchEnrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_enrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supervisor_id',15)->index();
            $table->integer('semester_id')->unsigned()->index();
            $table->integer('exam_time_id')->unsigned()->index();
            $table->integer('batch_id')->unsigned()->index();
            $table->timestamps();

            $table->foreign('supervisor_id')->references('user_id')->on('users');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('batch_id')->references('id')->on('batches');
            $table->foreign('exam_time_id')->references('id')->on('exam_times');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_enrolls');
    }
}
