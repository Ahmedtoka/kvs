<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('users')->where('email', 'Doaa@kvs.com')->exists()) {
            DB::table('users')->insert([
                'name'       => 'Doaa',
                'email'      => 'Doaa@kvs.com',
                'password'   => Hash::make('Doaa@KVS2026'),
                'role'       => 'sales_agent',
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('users')->where('email', 'Doaa@kvs.com')->delete();
    }
};
