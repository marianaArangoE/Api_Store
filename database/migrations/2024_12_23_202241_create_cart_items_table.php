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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id('CartItemID'); // Primary Key
            $table->unsignedBigInteger('CartID'); // Foreign Key to ShoppingCart
            $table->unsignedBigInteger('VariantID'); // Foreign Key to ProductVariants
            $table->integer('Quantity'); // Cantidad de productos
            $table->decimal('UnitPrice', 10, 2); // Precio unitario
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('CartID')->references('CartID')->on('shopping_cart')->onDelete('cascade');
            $table->foreign('VariantID')->references('VariantID')->on('product_variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
