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
        // Table area parkir
        Schema::create('parking_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rate_id')->constrained('rates')->cascadeOnDelete();
            $table->string('name', 255)->unique()->comment('Nama area parkir');
            $table->integer('capacity')->default(0)->comment('Kapasitas maksimal parkiran');
            $table->enum('type', ['private', 'public'])->comment('Tipe area parkir private atau public');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_areas');
    }
};
