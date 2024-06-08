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
        Schema::create('emergency_liquidation_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emergency_id');
            $table->unsignedInteger('firehouse_id');
            $table->boolean('is_accepted')->nullable()->default(null);
            $table->text('decline_comment')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('emergency_id')
                ->references('id')
                ->on('emergencies');

            $table->foreign('firehouse_id')
                ->references('id')
                ->on('firehouses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_liquidation_requests');
    }
};
