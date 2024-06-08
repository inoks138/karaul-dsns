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
        Schema::create('emergency_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedBigInteger('created_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_types');
    }
};
