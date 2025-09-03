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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            

              // === Másold be ezt a részt ===
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('subject');
        $table->text('message');
        $table->string('status')->default('Új');
        $table->string('attachment')->nullable();
        // ============================
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
