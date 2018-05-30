<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Admin\Student;

class CreateStudentsTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supervisor_id',15)->index();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('batch_id');
            $table->integer('class_roll')->index();
            $table->integer('exam_roll')->index();
            $table->string('reg_no')->index();
            $table->string('gender',1);
            $table->string('phone');
            $table->string('blood_group');
            $table->string('image')->nullable();
            $table->string('guardian');
            $table->string('guardian_contact');
            $table->boolean('is_present')->default(Student::PRESENT_STUDENT);
            $table->boolean('is_active')->default(Student::DEACTIVE_STUDENT);
            $table->timestamps();

        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
