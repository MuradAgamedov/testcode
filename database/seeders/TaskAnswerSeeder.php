<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskAnswer;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Support\Facades\DB;

class TaskAnswerSeeder extends Seeder
{
    public function run()
    {
        // Alma istifadəçisinin ID-sini tapın
        $user = User::where('email', 'armud@gmail.com')->first();

        // Uygun vakansiyaları tapın
        $vacancies = Vacancy::where('user_id', $user->id)->get();

        // Task Answer yaratmaq üçün
        foreach ($vacancies as $vacancy) {
            TaskAnswer::create([
                'user_id' => $user->id,
                'vacancy_id' => $vacancy->id,
                'application_status_id' => 1,  // Məsələn, `1` pending statusu
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
