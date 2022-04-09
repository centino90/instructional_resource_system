<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('enabled_notifications_in_course');
            $table->boolean('enabled_notifications_in_lessons');
            $table->boolean('enabled_notifications_in_users');
            $table->integer('interval_notifications_in_syllabus');
            $table->integer('interval_notifications_in_lessons');
            $table->integer('interval_notifications_in_resources');

            $table->boolean('enabled_watermarks_in_resource')->default(true);
            $table->boolean('enabled_watermarks_in_reports')->default(true);
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
        Schema::dropIfExists('admin_settings');
    }
}
