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
            $table->foreignId('parking_area_id')->constrained('parking_areas')->cascadeOnDelete();
            $table->string('vehicle_id', 20)->comment('ID Kendaraan Contoh AB1BA');
            $table->datetime('date_in')->comment('Waktu Masuk');
            $table->datetime('date_out')->nullable()->default(null)->comment('Waktu Keluar');
            $table->integer('minutes_duration')->default(0)->comment('Durasi Parkir Dalam Menit');
            $table->bigInteger('amount')->default(0)->comment('Total Biaya Parkir');
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
