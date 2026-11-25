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
    Schema::create('profiles', function (Blueprint $table) {
        $table->id();
        $table->string('name')->default('Dukuh Candi');
        $table->string('slug')->unique()->default('dukuh-candi');
        $table->text('description')->nullable();
        $table->text('history')->nullable();
        $table->text('vision')->nullable();
        $table->text('mission')->nullable();
        $table->text('address')->nullable();
        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->string('map_url')->nullable();
        $table->string('logo_path')->nullable();
        $table->string('cover_image_path')->nullable();
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
