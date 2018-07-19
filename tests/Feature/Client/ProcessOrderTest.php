<?php

namespace Tests\Feature\Client;

use Tests\TestCase;
use App\{Order, User};
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProcessOrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_non_client_cannot_update_a_order()
    {
        $order = $this->create(Order::class);

        $this->actingAs($this->create(User::class))
            ->put(route('client.orders.update', [
                'website' => $order->website,
                'order' => $order
            ]), [])
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect('/home');
    }

    /** @test */
    function client_update_their_orders()
    {
        $order = $this->create(Order::class, [
            'status' => Order::STATUS_CURRENT
        ]);

        $this->actingAs($order->website->user)
            ->put(route('client.orders.update', [
                'website' => $order->website,
                'order' => $order
            ]), [
                'status' => Order::STATUS_COMPLETE
            ])
            ->assertOk();

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => Order::STATUS_COMPLETE
        ]);
    }

    /** @test */
    function client_only_can_change_price_is_order_is_wait()
    {
        $this->withExceptionHandling();

        $order = $this->create(Order::class, [
            'status' => Order::STATUS_WAIT
        ]);

        $this->actingAs($order->website->user)
            ->put(route('client.orders.update', [
                'website' => $order->website,
                'order' => $order
            ]), [
                'price' => 100,
                'status' => Order::STATUS_COMPLETE
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    function it_see_show_errors_is_order_change_price_in_current()
    {
        $this->withExceptionHandling();

        $order = $this->create(Order::class, [
            'status' => Order::STATUS_CURRENT
        ]);

        $this->actingAs($order->website->user)
            ->put(route('client.orders.update', [
                'website' => $order->website,
                'order' => $order
            ]), [
                'price' => 100,
                'status' => Order::STATUS_COMPLETE
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /** @test */
    function it_see_show_errors_is_order_change_status_or_price_in_complete_or_cancel()
    {
        $this->withExceptionHandling();

        $order = $this->create(Order::class, [
            'status' => Order::STATUS_COMPLETE
        ]);

        $this->actingAs($order->website->user)
            ->put(route('client.orders.update', [
                'website' => $order->website,
                'order' => $order
            ]), [
                'price' => 100,
                'status' => Order::STATUS_CANCEL
            ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
