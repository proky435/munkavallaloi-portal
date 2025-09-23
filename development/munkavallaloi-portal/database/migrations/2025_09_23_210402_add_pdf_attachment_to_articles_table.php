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
        Schema::table('articles', function (Blueprint $table) {
            $table->string('pdf_attachment')->nullable()->after('content');
            $table->string('pdf_original_name')->nullable()->after('pdf_attachment');
            $table->integer('pdf_size')->nullable()->after('pdf_original_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['pdf_attachment', 'pdf_original_name', 'pdf_size']);
        });
    }
};
