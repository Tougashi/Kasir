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
            $table->unsignedBigInteger('transactionId');
            $table->json('productId');
            $table->unsignedBigInteger('custId');
            $table->unsignedBigInteger('userId');
            $table->json('quantity');
            $table->decimal('totalPrice', 10,2);
            $table->timestamps();

            $table->foreign('transactionId')->references('id')->on('transactions')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('productId')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('custId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
