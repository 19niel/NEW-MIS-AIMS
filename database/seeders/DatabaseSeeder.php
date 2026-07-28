<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'Admin']);
        $itRole = Role::create(['name' => 'IT']);
        $staffRole = Role::create(['name' => 'Staff']);

        // Create Admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);
        
        // Create IT user
        $it = User::factory()->create([
            'name' => 'IT User',
            'username' => 'it_user',
            'email' => 'it@example.com',
            'password' => Hash::make('password'),
        ]);
        $it->assignRole($itRole);

        // Create Staff user
        $staff = User::factory()->create([
            'name' => 'Staff User',
            'username' => 'staff_user',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
        ]);
        $staff->assignRole($staffRole);

        // Seed default asset categories
        $this->call([
            AssetCategorySeeder::class,
        ]);
    }
}
