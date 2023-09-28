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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->unsignedBigInteger('supplier_actor_id');
            $table->foreign('supplier_actor_id')->references('id')->on('actors');
            $table->unsignedBigInteger('input_product_id')->nullable();
            $table->foreign('input_product_id')->references('id')->on('inputs');
            $table->unsignedBigInteger('output_product_id')->nullable();
            $table->foreign('output_product_id')->references('id')->on('products');
            //$table->date('date');
            $table->integer('quantity');
            $table->string('metric');
            $table->integer('price')->nullable();
            $table->string('term_duration')->nullable();
            //$table->string('mode_of_acquisition');
            //$table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
