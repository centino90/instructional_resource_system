<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyllabiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllabi', function (Blueprint $table) {
            $table->foreignId('resource_id')->constrained();
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
            $table->primary('resource_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('syllabi');
    }
}