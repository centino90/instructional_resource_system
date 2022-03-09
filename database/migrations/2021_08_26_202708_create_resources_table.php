<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->uuid('batch_id')->nullable();
            $table->longText('title');
            $table->longText('description')->nullable();
            $table->boolean('is_syllabus')->default(0);
            $table->boolean('is_presentation')->default(0);
            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);

            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable(); //temp
            $table->timestamp('archived_at')->nullable();
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
        Schema::dropIfExists('resources');
    }
}
