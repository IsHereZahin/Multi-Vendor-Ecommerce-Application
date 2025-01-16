<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('slogan');
            $table->string('support_phone');
            $table->string('email');
            $table->string('address');
            $table->string('facebook_username');
            $table->string('twitter_username');
            $table->string('instagram_username');
            $table->string('youtube_username');
            $table->string('timezone');
            $table->string('open_hours');
            $table->string('open_days');
            $table->boolean('maintenance_mode')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
