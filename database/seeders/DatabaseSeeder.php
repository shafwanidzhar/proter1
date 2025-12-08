<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Headmaster
        \App\Models\User::factory()->create([
            'name' => 'Kepala Sekolah',
            'email' => 'headmaster@example.com',
            'password' => bcrypt('password'),
            'role' => 'headmaster',
        ]);

        // Teacher
        \App\Models\User::factory()->create([
            'name' => 'Guru Budi',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password'),
            'role' => 'teacher',
        ]);

        // Parent
        $parent = \App\Models\User::factory()->create([
            'name' => 'Orang Tua Ani',
            'email' => 'parent@example.com',
            'password' => bcrypt('password'),
            'role' => 'parent',
        ]);

        // Student
        \App\Models\Student::create([
            'parent_id' => $parent->id,
            'name' => 'Ani',
            'class' => 'TK A',
        ]);
    }
}
