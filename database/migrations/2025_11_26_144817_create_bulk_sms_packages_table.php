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
        Schema::create('bulk_sms_packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_name')->nullable();
            $table->integer('quantity');
            $table->decimal('sms_cost', 10, 2);
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('offer_amount', 10, 2)->nullable();
            $table->decimal('gst', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bulk_sms_packages');
    }
};
