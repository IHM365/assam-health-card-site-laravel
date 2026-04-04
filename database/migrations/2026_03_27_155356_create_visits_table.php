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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete()->index();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete()->index();
            $table->unsignedTinyInteger('discount_percentage');
            $table->decimal('discount_amount', 10, 2);
            $table->decimal('original_amount', 10, 2)->nullable();
            $table->timestamp('visited_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
