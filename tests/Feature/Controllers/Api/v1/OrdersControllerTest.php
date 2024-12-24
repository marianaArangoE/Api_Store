<?php

namespace Tests\Feature\Controllers\Api\v1;


use App\Models\Order;
use App\Models\User;



use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;

use Tests\TestCase;


class OrdersControllerTest extends TestCase
{


    protected function setUp(): void
    {
        parent::setUp();

        // Ejecutar las migraciones antes de cada prueba
        Artisan::call('migrate');
    }

    public function test_example(): void
    {
        $user = User::factory()->create(); // Crear usuario

        // Crear órdenes asociadas al usuario
        Order::factory()->count(3)->for($user)->create();

        // Autenticar al usuario
        $this->actingAs($user, 'sanctum');

        // Realizar la solicitud
        $response = $this->getJson('/api/v1/orders');

        // Validar la respuesta
        $response->assertStatus(200);
    }
}
