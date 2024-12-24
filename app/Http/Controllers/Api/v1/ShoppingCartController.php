<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShoppingCartController extends Controller
{
    /**
     * Crear o recuperar un carrito de compras.
     */
    public function store(Request $request)
    {
        // Verifica que el usuario esté autenticado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Crea o recupera el carrito activo del usuario
        $cart = ShoppingCart::firstOrCreate(
            ['UserID' => $user->id, 'Status' => 'active'],
            ['CreatedDate' => now()]
        );

        return response()->json([
            'message' => 'Shopping cart created successfully',
            'cart' => $cart,
        ]);
    }

    /**
     * Mostrar el carrito con los ítems.
     */
    public function show()
    {
        // Verifica que el usuario esté autenticado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Recupera el carrito activo del usuario
        $cart = ShoppingCart::with('cartItems')->where([
            ['UserID', '=', $user->id],
            ['Status', '=', 'active']
        ])->first();

        if (!$cart) {
            return response()->json(['message' => 'Shopping cart not found'], 404);
        }

        return response()->json(['cart' => $cart]);
    }

    /**
     * Actualizar el estado del carrito (opcional).
     */
    public function updateStatus(Request $request, $id)
    {
        $cart = ShoppingCart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Shopping cart not found'], 404);
        }

        $cart->update(['Status' => $request->input('Status')]);

        return response()->json(['message' => 'Shopping cart updated successfully']);
    }
}
