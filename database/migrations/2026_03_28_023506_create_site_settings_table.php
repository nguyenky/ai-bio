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
            $table->string('hero_heading');
            $table->string('short_bio');
            $table->text('intro_text');
            $table->string('profile_image_path')->nullable();
            $table->string('profile_image_url', 2048)->nullable();
            $table->string('instagram_profile_url', 2048)->nullable();
            $table->string('linkedin_url', 2048)->nullable();
            $table->string('github_url', 2048)->nullable();
            $table->string('x_url', 2048)->nullable();
            $table->string('seo_title');
            $table->string('seo_description', 255);
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
