<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// YENİ Skill modeli
class Skill extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'skill_user');
    }

    public function vacancies()
    {
        return $this->belongsToMany(Vacancy::class, 'skill_job', 'skill_id', 'vacancy_id');
    }
}

