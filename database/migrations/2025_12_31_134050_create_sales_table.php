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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('lead_id');
            $table->string('order_no')->unique();
            $table->date('date');

            $table->string('invoice_no')->nullable();
            $table->boolean('converted_invoice')->default(0);
            $table->string('type')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('payment_mode')->nullable();
            $table->text('transaction_details')->nullable();

            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('gst', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['paid','pending','cancelled'])->default('pending');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
