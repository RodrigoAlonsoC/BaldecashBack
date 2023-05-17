<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limitRows = 100;
        for ($i=0;$i<=$limitRows;$i++) {
            User::create($this->getData());
        }

      
    }

    public function getData(){
        return [
            'name' => Str::random(8),
            'last_name' => Str::random(8),
            'email' => Str::random(9).'@gmail.com',
            'password' => Hash::make('password'),
            'role' => rand(0,1),
        ];
    }
    
}
