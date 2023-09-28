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
        Schema::create('player_product_inputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('player_product_id');
            $table->foreign('player_product_id')->references('id')->on('player_products');
            $table->unsignedBigInteger('input_id');
            $table->foreign('input_id')->references ('id')->on('inputs');
            $table->integer('quantity');
            $table->string('metric');
            $table->string('transaction_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('player_product_inputs');
    }
};
