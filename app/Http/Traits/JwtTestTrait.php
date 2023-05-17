<?php
namespace App\Http\Traits;

use Tymon\JWTAuth\Facades\JWTAuth;

trait JwtTestTrait {
    
    /**
     * Email for test.
     *
     * @var string
     */
    private $emailTest = "rodrigocanaza81@gmail.com";
    /**
     * PAssword for test.
     *
     * @var string
     */
    private $passwordTest = "123456";

    /**
     * Generate JWT Token for tests
     *
     * @return array
     */
    public function generateJwtToken() : array
    { 
        $jwt = JWTAuth::attempt(["email"=> $this->emailTest,"password" => $this->passwordTest],false);
        return compact('jwt');
    }

}