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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
            $table->string('birth_place')->nullable()->after('birth_date');
            $table->string('street_address')->nullable()->after('birth_place');
            $table->string('city')->nullable()->after('street_address');
            $table->string('postal_code')->nullable()->after('city');
            $table->string('country')->nullable()->after('postal_code');
            $table->string('bank_account_number')->nullable()->after('country');
            $table->string('tax_number')->nullable()->after('bank_account_number');
            $table->string('social_security_number')->nullable()->after('tax_number');
            $table->string('emergency_contact_name')->nullable()->after('social_security_number');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_name');
            $table->unsignedBigInteger('workplace_id')->nullable()->after('emergency_contact_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'birth_date',
                'birth_place',
                'street_address',
                'city',
                'postal_code',
                'country',
                'bank_account_number',
                'tax_number',
                'social_security_number',
                'emergency_contact_name',
                'emergency_contact_phone',
                'workplace_id'
            ]);
        });
    }
};
