<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        $users = [
            ['name' => 'KVS Administrator', 'email' => 'superadmin@kvs.com', 'password' => 'Super@KVS2026',   'role' => 'super_admin'],
            ['name' => 'KVS Sales',         'email' => 'sales@kvs.com',      'password' => 'Sales@KVS2026',   'role' => 'sales_agent'],
            ['name' => 'KVS Media Buyer',   'email' => 'media@kvs.com',      'password' => 'Media@KVS2026',   'role' => 'media_buyer'],
            ['name' => 'KVS Content Editor','email' => 'content@kvs.com',    'password' => 'Content@KVS2026', 'role' => 'content_editor'],
        ];

        foreach ($users as $u) {
            if (! DB::table('users')->where('email', $u['email'])->exists()) {
                DB::table('users')->insert([
                    'name'       => $u['name'],
                    'email'      => $u['email'],
                    'password'   => Hash::make($u['password']),
                    'role'       => $u['role'],
                    'is_active'  => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('users')->whereIn('email', [
            'superadmin@kvs.com', 'sales@kvs.com', 'media@kvs.com', 'content@kvs.com',
        ])->delete();
    }
};
