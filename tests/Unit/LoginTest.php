<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithoutMiddleware;
    
    public function test_login_view(): void
    {
        $response = $this->get(uri: '/SignIn');
        $response->assertStatus(200);
    }

    public function test_check_login(): void
    {
        $credential = [
            "txtEmail" => "swain1467@gmail.com",
            "txtPassword" => "password"
        ];
        $this->post('CheckLogIn', $credential)->assertRedirect('UserDashboard');
    }

    public function test_get_type_data()
    {
        $response = $this->get('GetCityList');
        // $response->assertStatus(200);
    }
}
