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
        Schema::create('guards', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('firehouse_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->unsignedBigInteger('chief_id');
            $table->unsignedBigInteger('dispatcher_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('firehouse_id')
                ->references('id')
                ->on('firehouses');

            $table->foreign('chief_id')
                ->references('id')
                ->on('employees');

            $table->foreign('dispatcher_id')
                ->references('id')
                ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guards');
    }
};
