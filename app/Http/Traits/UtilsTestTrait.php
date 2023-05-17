<?php
namespace App\Http\Traits;

trait UtilsTestTrait {
    
    /**
     * Generate random char or num
     *
     * @return void
     */
    public function rand()
    {
        return substr(md5(microtime()), rand(0, 10), 5);
    }

    /**
     * Generate data random
     */
    public function generateData(): array
    {
        return array(
            "name" => "TESTBALDECASH".$this->rand(),
            "last_name" => $this->rand(),
            "email" =>  $this->rand() . "@gmail.com",
            "password" => $this->rand(),
            "role" => 0,
        );
    }

    /**
     * Generate data fail
     */
    public function generateDataFail(): array
    {
        return array(
            "name" => "TESTBALDECASH".$this->rand(),
            "last_name" => $this->rand(),
            "email" =>  $this->rand() . "@gmail.com",
            "password" => $this->rand(),
            "role" => 0,
        );
    }

}