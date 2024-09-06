<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'name' => 'widi fitriyani',
            'email' => 'widifit33@gmail.com',
            'role_id' => '2',
            'password' => Hash::make(1234),
        ]);
    }
}
