<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;

// class CartItem extends Model
// {
//     use HasFactory;

//     protected $table = 'cart_items';

//     protected $fillable = [
//         'CartID',
//         'VariantID',
//         'Quantity',
//         'UnitPrice',
//     ];

//     /**
//      * Relación con ShoppingCart.
//      */
//     public function shoppingCart()
//     {
//         return $this->belongsTo(ShoppingCart::class, 'CartID', 'CartID');
//     }

//     /**
//      * Relación con ProductVariant.
//      */
//     public function productVariant()
//     {
//         return $this->belongsTo(ProductVariant::class, 'VariantID', 'id');
//     }

    
// }


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';

    // Declarar la clave primaria personalizada
    protected $primaryKey = 'CartItemID';

    // Indicar que la clave primaria es auto-incremental
    public $incrementing = true;

    // Especificar el tipo de dato de la clave primaria
    protected $keyType = 'int';

    protected $fillable = [
        'CartID',
        'VariantID',
        'Quantity',
        'UnitPrice',
    ];

    /**
     * Relación con ShoppingCart.
     */
    public function shoppingCart()
    {
        return $this->belongsTo(ShoppingCart::class, 'CartID', 'CartID');
    }

    /**
     * Relación con ProductVariant.
     */
    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'VariantID', 'id');
    }
}
