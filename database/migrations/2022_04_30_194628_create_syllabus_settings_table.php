<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyllabusSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('syllabus_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('course_outcomes_table_no')->default(0);
            $table->integer('course_outcomes_row_no')->default(0);
            $table->integer('course_outcomes_col_no')->default(0);

            $table->integer('student_outcomes_table_no')->default(0);
            $table->integer('student_outcomes_row_no')->default(0);
            $table->integer('student_outcomes_col_no')->default(0);

            $table->integer('lesson_table_no')->default(0);
            $table->integer('lesson_row_no')->default(0);
            $table->integer('lesson_col_no')->default(0);

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
        Schema::dropIfExists('syllabus_settings');
    }
}
