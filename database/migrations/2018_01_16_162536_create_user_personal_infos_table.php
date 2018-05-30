<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserPersonalInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_personal_infos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id',15)->index();
            $table->string('supervisor_id',15)->index();
            $table->string('designation')->nullable();
            $table->string('mobile')->nullable();
            $table->tinyinteger('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('image')->nullable();
            $table->date('joining_date')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users');
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
        Schema::dropIfExists('user_personal_infos');
    }
}
