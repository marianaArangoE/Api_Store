<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Get the logged in user's orders, using model relation.
        $orders = auth()->user()->orders;
        return response()->json($orders, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Verifica si el usuario está autenticado
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Obtener los productos del carrito del usuario
        $cartItems = $user->cart; // Asume que tienes una relación 'cart' en el modelo User

        // Verifica si el carrito está vacío
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty'], 400);
        }

        // Usa una transacción para garantizar la consistencia de los datos
        \DB::beginTransaction();

        try {
            // Crear la orden
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // Puedes ajustar el estado inicial según tu lógica
                'total' => $cartItems->sum(function ($item) {
                    return $item->price * $item->pivot->quantity; // Calcula el total basado en precio y cantidad
                }),
            ]);

            // Asociar los productos del carrito a la orden
            foreach ($cartItems as $item) {
                $order->items()->create([
                    'product_id' => $item->id,
                    'quantity' => $item->pivot->quantity,
                    'price' => $item->price,
                ]);
            }

            // Limpia el carrito del usuario
            $user->cart()->detach();

            \DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order
            ], 201);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Get user orders by id
        $order = Order::with('items')->find($id);

        //Use Gate so that the logged in user can see only their orders. Gate rules are in the boot method of the AppServiceProviders class
        if (! Gate::allows('user-view-order', $order)) {
            return response()->json(['message' => 'Sorry, You dont have access to this resources'], 403);
        }

        return response()->json($order, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
