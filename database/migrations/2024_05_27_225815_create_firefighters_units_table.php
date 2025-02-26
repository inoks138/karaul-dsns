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
        Schema::create('firefighters_units', function (Blueprint $table) {
            $table->unsignedBigInteger('firefighter_id');
            $table->unsignedBigInteger('unit_id');

            $table->foreign('firefighter_id')
                ->references('id')
                ->on('employees');

            $table->foreign('unit_id')
                ->references('id')
                ->on('units');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firefighters_units');
    }
};
