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
        Schema::create('shopping_cart', function (Blueprint $table) {
            $table->id('CartID'); // Clave primaria
            $table->unsignedBigInteger('UserID'); // Clave foránea a la tabla Users
            $table->timestamp('CreatedDate')->useCurrent(); // Fecha de creación con valor predeterminado
            $table->string('Status', 50); // Estado del carrito (por ejemplo, "active", "completed")
            $table->timestamps(); // Campos created_at y updated_at automáticos

            // Clave foránea
            $table->foreign('UserID')->references('UserID')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shopping_cart');
    }
};
