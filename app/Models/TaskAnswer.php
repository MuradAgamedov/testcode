<?php

// app/Models/TaskAnswer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskAnswer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'vacancy_id',
        'application_status_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }
}
