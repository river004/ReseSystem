<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // すでに存在する場合はスキップ
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'admin',
                'email' => 'aporo423@gmail.com',
                'password' => Hash::make('hyjukilo0'),
                'role' => 'admin',
            ]);
        }
    }
}
