<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Testing purpose only no practical uses
use App\Models\User;
// For multiple dummy data
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for($i=1; $i<=5; $i++){
            $user = new User;
            $user->name = $faker->name;
            $user->email = $faker->email;
            $user->otp = '';
            $user->password = password_hash("password", PASSWORD_DEFAULT);
            $user->status = 1;  
            $user->created_at = now();  
            $user->updated_at = now();  
            $user->save();
        }
    }
}
