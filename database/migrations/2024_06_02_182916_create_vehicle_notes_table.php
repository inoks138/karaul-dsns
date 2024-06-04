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
        Schema::create('vehicle_notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('guard_id');
            $table->unsignedInteger('state_id');
            $table->string('state_comment')->nullable()->default(null);
            $table->string('fuel');
            $table->string('fire_extinguishing_equipment');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles');

            $table->foreign('guard_id')
                ->references('id')
                ->on('guards');

            $table->foreign('state_id')
                ->references('id')
                ->on('vehicle_note_states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_notes');
    }
};
