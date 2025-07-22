<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vacancy extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'is_internship',
        'deadline',
        'vacancy_type',
        'technical_task_time',
        'technical_task_path',
        'user_id',
        'experience_year',
    ];

    protected $appends = ['is_wishlisted', 'experience_year_label'];

    protected $with = ['skills']; // Burada 'experienceLevel' artıq lazım deyil

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_job', 'vacancy_id', 'skill_id');
    }

    public function getImageAttribute($value)
    {
        return url('storage/' . $value);
    }

    public function applicants()
    {
        return $this->hasMany(VacancyApplication::class);
    }

    public function getFileAttribute($value)
    {
        return $value ? url('storage/' . $value) : null;
    }

    public function wishlists()
    {
        return $this->hasMany(WishlistJob::class);
    }

    public function getIsWishlistedAttribute()
    {
        if (!auth()->check()) {
            return false;
        }

        return $this->wishlists()->where('user_id', auth()->id())->exists();
    }

    // Yeni: təcrübə ili üçün label
    public function getExperienceYearLabelAttribute()
    {
        if (is_null($this->experience_year)) return null;

        return match ($this->experience_year) {
            0 => 'No experience',
            1 => '1 year',
            2, 3, 4 => "{$this->experience_year} years",
            5 => '5+ years',
            default => "{$this->experience_year} years",
        };
    }
}
