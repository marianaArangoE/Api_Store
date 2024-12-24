<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'shopping_cart';

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'UserID',
        'CreatedDate',
        'Status',
    ];

    // Deshabilitar las marcas de tiempo automáticas (si no usas `created_at` y `updated_at`)
    public $timestamps = false;

    /**
     * Relación con el modelo User
     * Cada carrito pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    /**
     * Relación con los ítems del carrito
     * Cada carrito tiene varios ítems.
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'CartID', 'CartID');
    }
}
