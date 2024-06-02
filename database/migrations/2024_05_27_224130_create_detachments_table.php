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
        Schema::create('detachments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('headquarter_id');
            $table->unsignedInteger('number');
            $table->softDeletes();

            $table->foreign('headquarter_id')
                ->references('id')
                ->on('headquarters');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detachments');
    }
};
