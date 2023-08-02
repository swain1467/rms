<?php

namespace Tests\Unit;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_login_view(): void
    {
        $response = $this->get(uri: '/SignIn');
        $response->assertStatus(200);
    }

    public function test_check_login(): void
    {
        $credential = [
            "txtEmail" => "sarthak@gmail.com",
            "txtPassword" => "password"
        ];
        $this->post('CheckLogIn', $credential)->assertRedirect('UserDashboard');
    }
}
