<?php

namespace Database\Seeders;

use App\Models\User;
use Config;
use Illuminate\Database\Seeder;
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
        $user = User::where('id', 1)->first();
        if (! isset($user)) {
            User::create([
                'name' => 'Admin',
                'email'=> 'admin@gmail.com',                
                'password' => Hash::make('123admin@')              
            ]);
        }
    }
}
