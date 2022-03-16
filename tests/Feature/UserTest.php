<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_route_returns_200()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_purchase_route_returns_200()
    {
        $response = $this->get('/purchase');

        $response->assertStatus(200);
    }

    public function test_checkout_route_returns_200()
    {
        $response = $this->get('/checkout');

        $response->assertStatus(200);
    }
}