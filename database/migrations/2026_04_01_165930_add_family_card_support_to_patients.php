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
        Schema::table('patients', function (Blueprint $table) {
            // Card type: 'individual' or 'family'
            $table->enum('card_type', ['individual', 'family'])->default('individual')->after('status');
            
            // For family cards: reference to primary member (main patient)
            $table->unsignedBigInteger('primary_member_id')->nullable()->after('card_type');
            $table->foreign('primary_member_id')->references('id')->on('patients')->onDelete('cascade');
            
            // Profile image path
            $table->string('profile_image')->nullable()->after('primary_member_id');
            
            // QR code path (auto-generated)
            $table->string('qr_code')->nullable()->after('profile_image');
            
            // Card validity date
            $table->date('card_validity_date')->nullable()->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropForeignKeyIfExists(['primary_member_id']);
            $table->dropColumn(['card_type', 'primary_member_id', 'profile_image', 'qr_code', 'card_validity_date']);
        });
    }
};
