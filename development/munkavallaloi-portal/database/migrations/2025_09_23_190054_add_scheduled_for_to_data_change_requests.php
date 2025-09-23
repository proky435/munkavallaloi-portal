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
        Schema::table('data_change_requests', function (Blueprint $table) {
            $table->datetime('scheduled_for')->nullable()->after('processed_at');
            $table->boolean('is_scheduled')->default(false)->after('scheduled_for');
            $table->datetime('reminder_sent_at')->nullable()->after('is_scheduled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_change_requests', function (Blueprint $table) {
            $table->dropColumn(['scheduled_for', 'is_scheduled', 'reminder_sent_at']);
        });
    }
};
