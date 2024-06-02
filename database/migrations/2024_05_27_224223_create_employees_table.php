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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('patronymic');
            $table->unsignedInteger('workplace_id');
            $table->string('workplace_type');
            $table->unsignedInteger('position_id');
            $table->boolean('can_be_unit_driver')->default(false);
            $table->boolean('can_be_unit_commander')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('position_id')
                ->references('id')
                ->on('employee_positions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
