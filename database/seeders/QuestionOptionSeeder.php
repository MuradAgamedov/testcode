<?php

namespace Database\Seeders;

use App\Models\QuestionOption;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionOptionSeeder extends Seeder
{
    public function run()
    {
        // Assuming there are at least 3 questions created previously
        $questions = Question::all();

        // Check if no questions exist
        if ($questions->isEmpty()) {
            $this->command->info('No questions available to associate options.');
            return;
        }

        // Seed options for each question
        foreach ($questions as $question) {
            QuestionOption::create([
                'question_id' => $question->id,
                'label' => 'A',
                'is_correct' => true,  // Set Option A as the correct one
                'option_text' => 'Option A for ' . $question->title,
            ]);

            QuestionOption::create([
                'question_id' => $question->id,
                'label' => 'B',
                'is_correct' => false,
                'option_text' => 'Option B for ' . $question->title,
            ]);

            QuestionOption::create([
                'question_id' => $question->id,
                'label' => 'C',
                'is_correct' => false,
                'option_text' => 'Option C for ' . $question->title,
            ]);

            QuestionOption::create([
                'question_id' => $question->id,
                'label' => 'D',
                'is_correct' => false,
                'option_text' => 'Option D for ' . $question->title,
            ]);
        }

        $this->command->info('Question options seeded successfully.');
    }
}
