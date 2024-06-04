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
        Schema::create('guard_reports', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('guard_id');
            $table->unsignedBigInteger('chief_id');
            $table->unsignedBigInteger('dispatcher_id');

            $table->unsignedInteger('vacation_employees_count');
            $table->unsignedInteger('sick_employees_count');
            $table->unsignedInteger('business_trip_employees_count');
            $table->unsignedInteger('stock_employees_count');

            $table->text('service_inspection');
            $table->text('malfunctions');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('guard_id')
                ->references('id')
                ->on('guards');

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
        Schema::dropIfExists('guard_reports');
    }
};
