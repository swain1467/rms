<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Type;
class TypeTest extends TestCase
{
    use WithoutMiddleware;
    
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_type_data_entry(): void
    {
        // Type::create([
        //     'type' => '1RK',
        //     'created_by' => 1,
        //     'updated_by' => 1,
        //     'status' => 1,
        //     'created_at' => date("Y-m-d H:i:s"),
        //     'updated_at' => date("Y-m-d H:i:s")
        // ]);
        $response = $this->get(uri: '/SignUp');
        $response->assertStatus(200);
    }
}
