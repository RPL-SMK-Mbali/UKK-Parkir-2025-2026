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
        // Table Tarif Parkir
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique()->comment('Nama Tarif Parkir');
            $table->bigInteger('hourly_rate')->comment('Tarif Parkir Per Jam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
