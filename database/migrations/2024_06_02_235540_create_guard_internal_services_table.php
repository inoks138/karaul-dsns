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
        Schema::create('guard_internal_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('report_id');
            $table->unsignedInteger('type_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamp('start_time');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('report_id')
                ->references('id')
                ->on('guard_reports');

            $table->foreign('type_id')
                ->references('id')
                ->on('guard_internal_service_types');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guard_internal_services');
    }
};
