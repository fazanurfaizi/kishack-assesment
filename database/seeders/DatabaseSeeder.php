<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $this->call([
            RoleSeeder::class
        ]);

        \App\Models\User::factory()->create([
            'username' => 'Test User',
            'email' => 'test@example.com',
            'role_id' => Role::where('name', 'admin')->first()
        ]);
    }
}
