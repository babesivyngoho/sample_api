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
        Schema::create('business_address', function (Blueprint $table) {
            $table->id();
            $table->string('no')->nullable();
            $table->string('street')->nullable();
            $table->unsignedBigInteger('municipality_city_id');
            $table->foreign('municipality_city_id')->references('id')->on('municipalities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_address');
    }
};
