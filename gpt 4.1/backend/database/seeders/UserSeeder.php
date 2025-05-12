<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the users table with admins and clients.
     */
    public function run(): void
    {
        // Création d'un administrateur principal
        User::factory()->create([
            'name' => 'Admin Principal',
            'email' => 'admin@zenith.com',
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+33600000001',
            'avatar' => 'https://i.pravatar.cc/150?img=1',
        ]);

        // Création de plusieurs clients
        User::factory(5)->create([
            'role' => 'client',
            'status' => 'active',
        ]);

        // Création de plusieurs admins secondaires
        User::factory(2)->create([
            'role' => 'admin',
            'status' => 'active',
        ]);
    }
}
