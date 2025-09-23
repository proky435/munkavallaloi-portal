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
            // Modify the status enum to include 'completed'
            $table->enum('status', ['pending', 'processing', 'approved', 'completed', 'rejected', 'revision_required'])
                  ->default('pending')
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_change_requests', function (Blueprint $table) {
            // Revert back to original enum values
            $table->enum('status', ['pending', 'processing', 'approved', 'rejected', 'revision_required'])
                  ->default('pending')
                  ->change();
        });
    }
};
