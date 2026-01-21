<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::firstOrCreate(['name' => 'Arosoft'], [
            'contact_email' => 'admin@arosoft.io',
            'status' => 'active',
        ]);

        User::firstOrCreate(
            ['email' => 'admin@arosoft.io'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'tenant_id' => $tenant->id,
            ]
        );
    }
}
