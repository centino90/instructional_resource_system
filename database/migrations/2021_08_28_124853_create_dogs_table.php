<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dogs', function (Blueprint $table) {
            $table->id();
            $table->string('course_code');
            $table->string('course_title');
            $table->string('credit');
            $table->string('time_allotment');
            $table->string('professor');

            // chapter 1
            $table->json('course_description')->nullable();

            // chapter 2
            $table->json('course_outcomes')->nullable();

            // chapter 3
            $table->json('learning_outcomes')->nullable();

            // chapter 4
            $table->json('learning_plan')->nullable();

            // chapter 5
            $table->json('student_outputs')->nullable();

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
        Schema::dropIfExists('dogs');
    }
}