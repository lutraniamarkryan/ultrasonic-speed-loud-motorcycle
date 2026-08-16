<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();

            $table->string('plate_number');

            $table->string('violation_type');

            $table->integer('recorded_speed')->nullable();

            $table->integer('decibel_level')->nullable();

            // Location of the violation
            $table->string('location')->nullable();

            $table->string('date')->nullable();

            $table->string('status')->default('Pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('violations');
    }
};