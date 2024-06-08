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
        Schema::create('vehicle_repair_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('submitted_by');
            $table->text('comment');
            $table->timestamp('approved_at')->nullable()->default(null);
            $table->timestamp('declined_at')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('vehicle_id')
                ->references('id')
                ->on('vehicles');

            $table->foreign('submitted_by')
                ->references('id')
                ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_repair_requests');
    }
};
