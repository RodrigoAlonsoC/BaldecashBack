<?php

namespace Tests\Feature;

use App\Http\Traits\JwtTestTrait;
use App\Http\Traits\UtilsTestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Trait for generate JWT Token for tests.
     */
    use JwtTestTrait, UtilsTestTrait;

    private $jwtTokenForTests = "";

    /**
     * A basic feature test login.
     *
     * @return void
     */
    public function test_login_api_success()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Register new User and return 200
     *
     * @return void
     */
    public function test_register_new_user_success()
    {
        $this->jwtTokenForTests = $this->generateJwtToken()['jwt'];
        $response = $this->post('/api/v1/user/create', $this->generateData(), [
            "Authorization" => "Bearer " . $this->jwtTokenForTests,
            
        ]);
        $response->assertStatus(200);
    }

    /**
     * Register fail and return 401
     *
     * @return void
     */
    public function test_register_new_user_fail()
    {
        $response = $this->post('/api/v1/user/create', $this->generateDataFail(), [
            "Authorization" => "Bearer " . $this->jwtTokenForTests,
            
        ]);
        $response->assertStatus(401);
    }

    
}
