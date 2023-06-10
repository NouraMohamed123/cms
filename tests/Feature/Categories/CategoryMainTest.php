<?php

namespace Tests\Feature\Categories;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryMainTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->put('test');
        // dd($response->getContent());
        // dd($response->json()['message']);//when return json use putJson
        $response->assertStatus(200);
    }

    public function test_product()
    {
        $response = $this->get('product');
        // dd($response->getContent());
        // dd($response->json()['message']);//when return json use putJson
        $response->assertStatus(200);
        //    $this->assertEquals();
        //      $this->assertEquals(count(),count());
    }
}