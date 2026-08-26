<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $roles = ['admin', 'moderator', 'user'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'rouhollah@gmail.com'],
            [
                'name' => 'Default Admin',
                'password' => bcrypt('ChangeThis'), // Change this to a secure password
            ]
        );

        // Assign admin role to the default user
        $admin->assignRole('admin');
    }
}
