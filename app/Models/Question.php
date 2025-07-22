<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function correctOption()
{
    return $this->belongsTo(QuestionOption::class, 'correct_option_id');
}

    // App\Models\Question.php
    protected static function booted()
    {
        static::saved(function (Question $question) {
            if (request()->has('correct_option_label')) {
                $correctOption = $question->options()
                    ->where('label', request('correct_option_label'))
                    ->first();

                if ($correctOption) {
                    $question->update(['correct_option_id' => $correctOption->id]);
                }
            }
        });
    }



}
