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
            $table->string('name', 255);
            $table->integer('capacity')->default(0)->comment('Kapasitas maksimal parkiran');
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
