<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vacancy;
use App\Models\VacancyApplication;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VacancyApplicationSeeder extends Seeder
{
    public function run()
    {
        // HR istifadəçisi yaratmaq
        $hrUser = User::firstOrCreate(
            ['email' => 'armud@gmail.com'],
            [
                'name' => 'HR User',
                'password' => Hash::make('password123'),
                'user_type' => 'hr',
            ]
        );
        $hrUser = User::firstOrCreate(
            ['email' => 'armud1@gmail.com'],
            [
                'name' => 'HR User',
                'password' => Hash::make('password1234'),
                'user_type' => 'hr',
            ]
        );

        // İşçiləri yaratmaq
        $worker1 = User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make('password123'),
            'user_type' => 'worker',
        ]);

        $worker2 = User::create([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'password' => Hash::make('password123'),
            'user_type' => 'worker',
        ]);

        $worker3 = User::create([
            'name' => 'Alice',
            'email' => 'alice@example.com',
            'password' => Hash::make('password123'),
            'user_type' => 'worker',
        ]);

        // Şirkət ID-sini əldə et
        $company = \App\Models\Company::first(); // İlk şirkəti alırıq

        // Alma@gmail.com üçün vakansiya yaratmaq
        $vacancy1 = Vacancy::create([
            'title' => 'Software Developer',
            'description' => 'Develop software solutions',
            'user_id' => $hrUser->id,
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Başqa bir vakansiya yaratmaq
        $vacancy2 = Vacancy::create([
            'title' => 'Backend Developer',
            'description' => 'Work on server-side logic',
            'user_id' => $hrUser->id,
            
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // İşçilərdən müraciət edənlər
        VacancyApplication::create([
            'user_id' => $worker1->id,
            'vacancy_id' => $vacancy1->id,
            'application_status_id' => 1, // Statusu 'pending'
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        VacancyApplication::create([
            'user_id' => $worker2->id,
            'vacancy_id' => $vacancy1->id,
            'application_status_id' => 2, // Statusu 'approved'
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        VacancyApplication::create([
            'user_id' => $worker3->id,
            'vacancy_id' => $vacancy2->id,
            'application_status_id' => 3, // Statusu 'rejected'
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
