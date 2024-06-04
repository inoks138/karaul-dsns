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
        Schema::create('guard_fire_hose_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->float('diameter');
            $table->string('hose_number');
            $table->unsignedInteger('work_time_seconds');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('report_id')
                ->references('id')
                ->on('guard_reports');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_fire_hose_usages');
    }
};
