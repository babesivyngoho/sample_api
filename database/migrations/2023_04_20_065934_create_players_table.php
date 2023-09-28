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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id');
            $table->foreign('actor_id')->references('id')->on('actors');
            $table->unsignedBigInteger('representative_id')->nullable();
            $table->foreign('representative_id')->references('id')->on('users');
            //$table->string('business_name');
            //$table->string('business_address');
            //$table->string('business_address_no')->nullable();
            //$table->string('business_address_street')->nullable();
            //$table->string('business_address_city_municipality');
            //$table->string('business_address_province');
            //$table->string('business_address_region');
            $table->unsignedBigInteger('business_address_id');
            $table->foreign('business_address_id')->references('id')->on('business_address');
            $table->string('business_contact_no')->nullable();
            $table->string('business_email_add')->nullable();
            $table->unsignedBigInteger('business_type_id')->nullable();
            $table->foreign('business_type_id')->references('id')->on('business_types');
            $table->string('owner_name')->nullable();
            $table->string('owner_sex_at_birth')->nullable();
            $table->string('sector')->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('vc_roles');
            $table->boolean('is_active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
