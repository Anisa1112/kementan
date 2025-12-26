<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contoh seeder bawaan Laravel (boleh dihapus kalau tidak dipakai)
        // \App\Models\User::factory(10)->create();

        User::updateOrCreate(
            [
                'email' => 'superadmin@gmail.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'superadmin'
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'adminpusdatin@gmail.com',
            ],
            [
                'name' => 'Admin Pusdatin',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin_pusdatin'
            ]
        );

        User::updateOrCreate(
            [
                'email' => 'admineselon@gmail.com',
            ],
            [
                'name' => 'Admin Eselon',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 'admin_eselon'
            ]
        );

        // Jalankan seeder PSP
        //$this->call(PrasaranaSaranaSeeder::class);
        //$this->call(KomoditasSeeder::class);
        
    }
    
}

    


