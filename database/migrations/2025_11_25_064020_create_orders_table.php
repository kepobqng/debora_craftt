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
            $table->foreignId('customer_id')->constrained();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('shipping_cost', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['new', 'processing', 'shipped', 'delivered', 'cancelled'])->default('new');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->enum('payment_method', ['cash', 'transfer', 'cod', 'credit_card'])->default('cash');
            $table->text('notes')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_phone')->nullable();
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
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
