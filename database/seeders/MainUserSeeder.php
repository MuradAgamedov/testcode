<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MainUserSeeder extends Seeder
{
    public function run(): void
    {
        // Get some companies for association
        $companies = Company::all();
        
        // Create HR users
        User::updateOrCreate(
            ['email' => 'hr@example.com'],
            [
                'name' => 'HR Manager',
                'password' => Hash::make('password123'),
                'user_type' => 'hr',
                'company_id' => $companies->first()?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'hr2@example.com'],
            [
                'name' => 'HR Assistant',
                'password' => Hash::make('password123'),
                'user_type' => 'hr',
                'company_id' => $companies->count() > 1 ? $companies->get(1)->id : $companies->first()?->id,
            ]
        );

        // Create Course users
        User::updateOrCreate(
            ['email' => 'course@example.com'],
            [
                'name' => 'Course Instructor',
                'password' => Hash::make('password123'),
                'user_type' => 'course',
                'company_id' => $companies->first()?->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'course2@example.com'],
            [
                'name' => 'Course Manager',
                'password' => Hash::make('password123'),
                'user_type' => 'course',
                'company_id' => $companies->count() > 1 ? $companies->get(1)->id : $companies->first()?->id,
            ]
        );

        // Create regular users
        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
                'user_type' => 'user',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('password123'),
                'user_type' => 'user',
                'company_id' => null,
            ]
        );

        User::updateOrCreate(
            ['email' => 'user3@example.com'],
            [
                'name' => 'Mike Johnson',
                'password' => Hash::make('password123'),
                'user_type' => 'user',
                'company_id' => null,
            ]
        );

        // Create additional users with different companies
        if ($companies->count() > 0) {
            User::updateOrCreate(
                ['email' => 'hr3@example.com'],
                [
                    'name' => 'Senior HR Manager',
                    'password' => Hash::make('password123'),
                    'user_type' => 'hr',
                    'company_id' => $companies->last()->id,
                ]
            );
        }
    }
} 