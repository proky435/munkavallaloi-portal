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
        Schema::table('tickets', function (Blueprint $table) {
            $table->json('form_data')->nullable(); // Store dynamic form data as JSON
            $table->string('subject')->nullable()->change(); // Make subject nullable
            $table->text('message')->nullable()->change(); // Make message nullable
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('form_data');
            $table->string('subject')->nullable(false)->change();
            $table->text('message')->nullable(false)->change();
        });
    }
};
