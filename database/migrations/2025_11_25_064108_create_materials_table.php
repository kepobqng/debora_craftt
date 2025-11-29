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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('unit')->default('pcs');
            $table->integer('current_stock')->default(0);
            $table->integer('min_stock')->default(5);
            $table->decimal('price', 10, 2)->default(0);
            $table->enum('type', ['flower', 'packaging', 'accessories', 'tools']);
            $table->enum('status', ['in_stock', 'low_stock', 'out_of_stock'])->default('in_stock');
            $table->string('supplier')->nullable();
            $table->string('supplier_phone')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
