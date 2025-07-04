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
            $table->string('description');
            $table->decimal('total_amount', 10, 2);
            $table->string('delivery_method')->default('shipping');
            $table->string('currency')->default('EGP');
            $table->text('customer_details')->nullable();
            $table->enum('status', ['pending', 'paid', 'cancelled', 'failed'])->default('pending');
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
