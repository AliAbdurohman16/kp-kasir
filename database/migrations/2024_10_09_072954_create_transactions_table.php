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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('cashier_id')->index();
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('cart_id')->index();
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->decimal('total', 10, 2);
            $table->decimal('money', 10, 2);
            $table->decimal('change_money', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
