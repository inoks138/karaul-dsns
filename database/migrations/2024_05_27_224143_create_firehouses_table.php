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
        Schema::create('firehouses', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('detachment_id');
            $table->unsignedInteger('number');
            $table->string('address');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('detachment_id')
                ->references('id')
                ->on('detachments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('firehouses');
    }
};
