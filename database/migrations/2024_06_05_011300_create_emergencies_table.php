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
        Schema::create('emergencies', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('type_id');
            $table->string('address');
            $table->text('comment');
            $table->unsignedInteger('reporter_workplace_id');
            $table->string('reporter_workplace_type');
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedInteger('fire_square')->nullable();
            $table->unsignedInteger('fire_square_after_localization')->nullable();
            $table->timestamp('reported_at');
            $table->timestamp('closed_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('reporter_id')
                ->references('id')
                ->on('employees');

            $table->foreign('type_id')
                ->references('id')
                ->on('emergency_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergencies');
    }
};
