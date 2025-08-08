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
            $table->string('phone')->after('email')->nullable(); // Store user's phone number
            $table->string('two_factor_code')->after('password')->nullable(); // Store the verification code
            $table->timestamp('two_factor_expires_at')->after('two_factor_code')->nullable(); // Expiry for the code
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
                'two_factor_code',
                'two_factor_expires_at',
            ]);
        });
    }
};
