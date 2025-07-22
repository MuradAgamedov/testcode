<?php
namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // İlk mövzulara aid məlumatları alırıq
        $webDevTopic = Topic::where('name', 'Web Development')->first();
        $frontEndTopic = Topic::where('name', 'Frontend Development')->first();
        $backEndTopic = Topic::where('name', 'Backend Development')->first();

        // İlk sualı əlavə edirik (Web Development)
        $question1 = Question::create([
            'title' => 'What is the main purpose of HTML?',
            'difficulty' => 'Easy',
            'topic_id' => $webDevTopic->id,  // Web Development mövzusu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Sual üçün seçimlər əlavə edirik
        $option1 = QuestionOption::create([
            'question_id' => $question1->id,
            'label' => 'A',
            'is_correct' => true,
            'option_text' => 'To structure content on the web',
        ]);

        $option2 = QuestionOption::create([
            'question_id' => $question1->id,
            'label' => 'B',
            'is_correct' => false,
            'option_text' => 'To style web pages',
        ]);

        $question1->update([
            'correct_option_id' => $option1->id,
        ]);

        // İkinci sualı əlavə edirik (Frontend Development)
        $question2 = Question::create([
            'title' => 'What is CSS used for?',
            'difficulty' => 'Easy',
            'topic_id' => $frontEndTopic->id,  // Frontend Development mövzusu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // İkinci sual üçün seçimlər
        $option3 = QuestionOption::create([
            'question_id' => $question2->id,
            'label' => 'A',
            'is_correct' => true,
            'option_text' => 'To style the web page',
        ]);

        $option4 = QuestionOption::create([
            'question_id' => $question2->id,
            'label' => 'B',
            'is_correct' => false,
            'option_text' => 'To add interactivity to the web page',
        ]);

        $question2->update([
            'correct_option_id' => $option3->id,
        ]);

        // Üçüncü sualı əlavə edirik (Backend Development)
        $question3 = Question::create([
            'title' => 'What is Node.js?',
            'difficulty' => 'Medium',
            'topic_id' => $backEndTopic->id, // Backend Development mövzusu
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Üçüncü sual üçün seçimlər
        $option5 = QuestionOption::create([
            'question_id' => $question3->id,
            'label' => 'A',
            'is_correct' => true,
            'option_text' => 'A JavaScript runtime environment',
        ]);

        $option6 = QuestionOption::create([
            'question_id' => $question3->id,
            'label' => 'B',
            'is_correct' => false,
            'option_text' => 'A JavaScript library for DOM manipulation',
        ]);

        $question3->update([
            'correct_option_id' => $option5->id,
        ]);
    }
}
