<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserQuestionScore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'question_id', 'score','question_option'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo 
    {
        return $this->belongsTo(Question::class);
    }

    public static function calculateScoreFor(string $difficulty): int
    {
        return match ($difficulty) {
            'Easy' => 10,
            'Medium' => 20,
            'Hard' => 30,
            default => 0,
        };
    }

    public function correctOption()
    {
        return $this->hasOne(QuestionOption::class, 'id', 'correct_option_id');
    }
}
