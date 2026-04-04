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
            $table->enum('address_proof_type', ['aadhar', 'passport', 'driving_license', 'utility_bill', 'rental_agreement', 'other'])->nullable()->after('address');
            $table->string('address_proof_file')->nullable()->after('address_proof_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('address_proof_type');
            $table->dropColumn('address_proof_file');
        });
    }
};
