<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('title');
            $table->foreignId('program_id')->constrained();
            $table->integer('year_level'); // 1-4
            // $table->string('school_year'); // 2021-...
            $table->integer('semester'); // 1-2
            $table->integer('term'); //1-2
            // Credit (2 - 3 units)
            // Time Allotment (50 - 60 hours)
            $table->timestamp('archived_at');
            $table->softDeletes();
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
        Schema::dropIfExists('courses');
    }
}