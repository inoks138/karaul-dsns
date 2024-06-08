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
        Schema::create('emergency_liquidations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->timestamp('departured_at')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->timestamp('first_barrel_delivered_at')->nullable();
            $table->timestamp('localized_at')->nullable();
            $table->timestamp('liquidated_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emergency_id')
                ->references('id')
                ->on('emergencies');

            $table->foreign('unit_id')
                ->references('id')
                ->on('units');

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_liquidations');
    }
};
