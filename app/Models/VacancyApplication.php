<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancyApplication extends Model
{
    use HasFactory, SoftDeletes;

   protected $guarded = [];
   protected $fillable = ['user_id', 'vacancy_id', 'application_status_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }


    public function application()
    {
        return $this->belongsTo(VacancyApplication::class, 'application_id');
    }

    public function applicationStatus()
    {
        return $this->belongsTo(ApplicationStatus::class);
    }


}
