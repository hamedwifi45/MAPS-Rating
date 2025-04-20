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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string("review");
            $table->integer('service_rating')->nullable();
            $table->integer('quality_rating')->nullable();
            $table->integer('cleanliness_rating')->nullable();
            $table->integer('pricing_rating')->nullable();
            $table->foreignId('place_id')->references("id")->on("places");
            $table->foreignId('user_id')->references("id")->on("users");
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
