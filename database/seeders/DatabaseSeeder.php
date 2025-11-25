<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        if (!User::where('email', 'admin@local.test')->exists()) {
            $admin = User::create([
                'username' => 'admin',
                'email' => 'admin@local.test',
                'full_name' => 'Admin User',
                'phone' => '9999999999',
                'password' => Hash::make('admin123')
            ]);
            $admin->assignRole('admin');
        }
    }
}
