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
        Schema::table('visits', function (Blueprint $table) {
            $table->string('service_type')->nullable()->after('original_amount');
            $table->text('notes')->nullable()->after('service_type');
            $table->enum('verification_method', ['qr', 'mobile', 'bill'])->default('qr')->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropColumn(['service_type', 'notes', 'verification_method']);
        });
    }
};
