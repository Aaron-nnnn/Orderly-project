<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

         User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Orderly Admin',
                'password' => Hash::make('12345678'),
                'role_id' => $adminRole->id,
                'phoneNumber' => '0796534016',
                'dob' => '2007-07-25',
                'gender' => 'male',
            ]
         );
    }
}
