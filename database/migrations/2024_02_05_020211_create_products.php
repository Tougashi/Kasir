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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoryId');
            $table->unsignedBigInteger('supplierId');
            $table->string('code');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('stock');
            $table->decimal('price', 10,2);
            $table->date('expiredDate');
            $table->string('image')->nullable();
            
            $table->foreign('categoryId')->references('id')->on('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('supplierId')->references('id')->on('suppliers')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.  
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
