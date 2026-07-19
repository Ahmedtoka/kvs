<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@kvs.edu.eg')],
            [
                'name'     => 'KVS Admin',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'KVS@Admin2026')),
            ]
        );
    }
}
