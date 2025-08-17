<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
      

        // Admin account
        \App\Models\User::create([
            'first_name' => 'Admin',
            'middle_name' => 'System',
            'last_name' => 'User',
            'suffix' => null,
            'age' => 30,
            'gender' => 'Male',
            'phone' => '09123456789',
            'rib_no' => 'admin001',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // Superadmin account
        \App\Models\User::create([
            'first_name' => 'Super',
            'middle_name' => 'Admin',
            'last_name' => 'User',
            'suffix' => null,
            'age' => 35,
            'gender' => 'Male',
            'phone' => '09876543210',
            'rib_no' => 'superadmin001',
            'password' => bcrypt('superadmin123'),
            'role' => 'superadmin',
        ]);
  // User::factory(10)->create();

  \App\Models\User::create([
    'first_name' => 'Richard',
    'middle_name' => 'Daseco',
    'last_name' => 'Bilan',
    'suffix' => 'Jr.',
    'age' => '21',
    'gender' => 'Male',
    'phone' => '09111111111',
    'rib_no' => '001',
    
    'password' => bcrypt('chad123'),
]);

\App\Models\User::create([
    'first_name' => 'Zaro',
    'middle_name' => 'Arcos',
    'last_name' => 'Quintanilla',
    'suffix' => null,
    'age' => '22',
    'gender' => 'Male',
    'phone' => '09987654321',
    'rib_no' => '002',
    'password' => bcrypt('zaro123'),
]);
        // Add a user with only names and rib_no for registration test
        \App\Models\User::create([
            'first_name' => 'Elaine',
            'middle_name' => 'Alcantara',
            'last_name' => 'Bertiz',
            'rib_no' => '003',
            'suffix' => null,
            'age' => null,
            'gender' => null,
            'phone' => null,
            'password' => null,
        ]);
        \App\Models\User::create([
            'first_name' => 'Kiezer',
            'middle_name' => 'Daseco',
            'last_name' => 'Bilan',
            'rib_no' => '004',
            'suffix' => null,
            'age' => null,
            'gender' => null,
            'phone' => null,
            'password' => null,
        ]);
        \App\Models\User::create([
            'first_name' => 'Sara',
            'middle_name' => 'casiban',
            'last_name' => 'Abane',
            'rib_no' => '005',
            'suffix' => null,
            'age' => null,
            'gender' => null,
            'phone' => null,
            'password' => null,
        ]);
    }
}
