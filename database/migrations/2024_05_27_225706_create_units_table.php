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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commander_id');
            $table->unsignedBigInteger('driver_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('guard_id');
            $table->timestamps();

            $table->foreign('commander_id')
                ->references('id')
                ->on('employees');

            $table->foreign('driver_id')
                ->references('id')
                ->on('employees');

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles');

            $table->foreign('guard_id')
                ->references('id')
                ->on('guards');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
