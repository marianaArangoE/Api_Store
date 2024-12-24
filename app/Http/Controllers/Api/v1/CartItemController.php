<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\CartItem;
use App\Models\ProductVariant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartItemController extends Controller
{
    /**
     * Listar los ítems de un carrito específico.
     */
    public function index($cartId)
    {
        $items = CartItem::where('CartID', $cartId)->get();
        return response()->json($items, 200);
    }

    /**
     * Agregar un ítem al carrito.
     */
    public function store(Request $request)
    {
        try {
            // Validar los datos de la solicitud
            $validatedData = $request->validate([
                'CartID' => 'required|exists:shopping_cart,CartID',
                'VariantID' => 'required|exists:product_variants,id',
                'Quantity' => 'required|integer|min:1',
                'UnitPrice' => 'required|numeric|min:0',
            ]);

            // Crear el ítem
            $cartItem = CartItem::create($validatedData);

            // Retornar la respuesta en JSON
            return response()->json($cartItem, 201);
        } catch (\Exception $e) {
            // Manejar errores y retornar una respuesta en JSON
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // public function store(Request $request)
    // {
    //     // Validar los datos del request
    //     $request->validate([
    //         'CartID' => 'required|exists:shopping_cart,CartID',
    //         'VariantID' => 'required|exists:product_variants,VariantID',
    //         'Quantity' => 'required|integer|min:1',
    //         'UnitPrice' => 'required|numeric|min:0',
    //     ]);

    //     // Verificar stock de la variante
    //     $variant = ProductVariant::find($request->input('VariantID'));
    //     if ($variant->StockQuantity < $request->input('Quantity')) {
    //         return response()->json(['message' => 'Not enough stock available'], 400);
    //     }

    //     // Crear el ítem en el carrito
    //     $cartItem = CartItem::create([
    //         'CartID' => $request->input('CartID'),
    //         'VariantID' => $request->input('VariantID'),
    //         'Quantity' => $request->input('Quantity'),
    //         'UnitPrice' => $request->input('UnitPrice'),
    //     ]);

    //     return response()->json([
    //         'message' => 'Cart item added successfully',
    //         'cartItem' => $cartItem,
    //     ], 201);
    // }


    /**
     * Actualizar un ítem del carrito.
     */
    // public function update(Request $request, $id)
    // {
    //     $validatedData = $request->validate([
    //         'Quantity' => 'nullable|integer|min:1',
    //         'UnitPrice' => 'nullable|numeric|min:0',
    //     ]);

    //     $item = CartItem::findOrFail($id);
    //     $item->update($validatedData);

    //     return response()->json($item, 200);
    // }

    public function update(Request $request, $CartItemID)
    {
        try {
            // Validar la cantidad enviada
            $validatedData = $request->validate([
                'Quantity' => 'required|integer|min:1', // La cantidad debe ser un entero >= 1
            ]);

            // Encontrar el CartItem usando el CartItemID
            $cartItem = CartItem::findOrFail($CartItemID);

            // Actualizar la cantidad
            $cartItem->update([
                'Quantity' => $validatedData['Quantity']
            ]);

            // Respuesta JSON con el CartItem actualizado
            return response()->json([
                'message' => 'Cart item updated successfully',
                'cartItem' => $cartItem,
            ], 200);
        } catch (\Exception $e) {
            // Manejar excepciones y errores
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Eliminar un ítem del carrito.
     */
    // public function destroy($id)
    // {
    //     $item = CartItem::findOrFail($id);
    //     $item->delete();

    //     return response()->json(['message' => 'Item deleted successfully'], 200);
    // }

    public function destroy($CartItemID)
    {
        try {
            // Buscar el CartItem por CartItemID
            $cartItem = CartItem::findOrFail($CartItemID);

            // Eliminar el CartItem
            $cartItem->delete();

            // Respuesta exitosa
            return response()->json([
                'message' => 'Cart item deleted successfully',
            ], 200);
        } catch (\Exception $e) {
            // Manejar errores
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
