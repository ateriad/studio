<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
    }

    public function createAdminUser()
    {
        $role = Role::firstOrCreate([
            'title' => 'super_admin'
        ], [
            'permissions' => json_encode(['super-admin']),
        ]);

        $user = User::firstOrCreate([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'cellphone' => '09123456789',
        ], [
            'password' => Hash::make('123'),
        ]);

        $user->roles()->save($role);
    }

}
