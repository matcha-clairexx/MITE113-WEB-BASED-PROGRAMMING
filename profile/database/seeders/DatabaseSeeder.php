<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::updateOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $user2 = User::updateOrCreate(
            ['email' => 'second@example.com'],
            [
                'name' => 'Second User',
                'password' => Hash::make('password'),
                'is_admin' => false,
            ]
        );

        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'student1@example.com'],
            [
                'name' => 'Student One',
                'program' => 'BS Information Technology',
                'year' => 3,
                'id_number' => '2026-0001',
                'owner_id' => $user1->id,
            ]
        );

        Student::updateOrCreate(
            ['email' => 'student2@example.com'],
            [
                'name' => 'Student Two',
                'program' => 'BS Information Technology',
                'year' => 2,
                'id_number' => '2026-0002',
                'owner_id' => $user2->id,
            ]
        );
    }
}
