<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new User([
            'name' => 'Julien P',
            'email' => 'Julien@gm.com',
            'password' => bcrypt('password'),
        ]);

        $user->save();

        $token = $user->createToken('authToken')->accessToken;
        echo "User created successfully. Token: $token";
    }
}
