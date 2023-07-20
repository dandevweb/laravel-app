<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(100)->create();

        $this->call([
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            DepartmentSeeder::class,
        ]);

        $role = Role::create(['name' => 'admin']);


        $user = \App\Models\User::factory()->create([
            'first_name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole($role);
    }
}
