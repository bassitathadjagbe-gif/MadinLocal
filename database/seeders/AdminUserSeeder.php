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
            ['email' => 'admin@madinlocal.com'],
            [
                'name' => 'Administrateur',
                'phone' => '+229 00 00 00 00',
                'password' => Hash::make('admin123'),
                'role' => 'client',
                'is_admin' => true,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Compte admin créé : admin@madinlocal.com / admin123');
    }
}