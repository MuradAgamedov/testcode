<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Question;
use App\Models\UserQuestionScore;
use Illuminate\Database\Seeder;

class UserQuestionScoreSeeder extends Seeder
{
    public function run()
    {
        // İstifadəçiləri və sualları əldə edirik
        $users = User::all();
        $questions = Question::all();

        // Əgər istifadəçi və ya suallar mövcud deyilsə, məlumat əlavə etmədən seeder dayandırılacaq
        if ($users->isEmpty() || $questions->isEmpty()) {
            $this->command->info('No users or questions available to associate with scores.');
            return;
        }

        // Hər bir istifadəçi üçün hər bir sualı random nəticə ilə qiymətləndiririk
        foreach ($users as $user) {
            foreach ($questions as $question) {
                UserQuestionScore::create([
                    'user_id' => $user->id,
                    'question_id' => $question->id,
                    'score' => rand(10, 30), // 10 ilə 30 arasında random nəticə
                    'question_option' => 'Option A', // Burada seçilən variantı istədiyiniz kimi dəyişə bilərsiniz
                ]);
            }
        }

        $this->command->info('User question scores seeded successfully.');
    }
}
