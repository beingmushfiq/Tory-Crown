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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('shipping_address');
            $table->string('city');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('vat_total', 12, 2);
            $table->decimal('shipping_charge', 12, 2);
            $table->decimal('discount_total', 12, 2)->default(0);
            $table->decimal('grand_total', 12, 2);
            $table->decimal('partial_advance', 12, 2)->default(0);
            $table->string('payment_method'); // bKash, Nagad, SSL, COD
            $table->string('payment_status')->default('pending');
            $table->string('order_status')->default('pending');
            $table->string('courier_status')->nullable();
            $table->string('consignment_id')->nullable();
            $table->string('tracking_url')->nullable();
            $table->string('event_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
