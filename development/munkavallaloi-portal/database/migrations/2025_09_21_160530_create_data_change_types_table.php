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
        Schema::create('data_change_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., 'name_change', 'workplace_change', 'address_change'
            $table->string('display_name'); // e.g., 'Név módosítás', 'Munkahely módosítás'
            $table->text('description')->nullable();
            $table->json('form_fields'); // Dynamic form configuration
            $table->json('required_documents')->nullable(); // Required document types
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_change_types');
    }
};
