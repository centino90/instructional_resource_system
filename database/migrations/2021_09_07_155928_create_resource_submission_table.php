<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceSubmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_submission', function (Blueprint $table) {
            $table->foreignId('resource_id')->constrained();
            $table->foreignId('submission_id')->constrained();
            $table->timestamp('approved_at');
            $table->timestamps();

            $table->primary(['resource_id', 'submission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_submission');
    }
}