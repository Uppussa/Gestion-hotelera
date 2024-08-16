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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->datetime('fc_log')->useCurrent();
            $table->string('action_log', 300)->nullable();
            $table->string('tipo_log', 300)->nullable();
            $table->string('ip_log', 300)->nullable();
            $table->string('table_log', 300)->nullable();
            $table->string('from_log', 300)->nullable();
            $table->foreignId('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
