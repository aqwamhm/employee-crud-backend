<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Position;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Position::insert([
            ['name' => 'Web Developer'],
            ['name' => 'Quality Assurance Engineer'],
            ['name' => 'UI/UX Designer'],
            ['name' => 'Project Manager'],
            ['name' => 'DevOps Engineer'],
        ]);

        Employee::factory()->count(50)->create();

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make("admin123"),
        ]);

        User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make("superadmin123"),
            'is_superadmin' => true
        ]);
    }
}
