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
        Schema::rename('timesheets', 'old_timesheets');
        Schema::create('timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('calendar_id');
            $table->foreignId('user_id');
            $table->enum('type', ['work', 'pause'])->default('work');
            $table->dateTime('day_in')->nullable();
            $table->dateTime('day_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
