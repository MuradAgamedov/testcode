<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // app/Models/User.php

    protected static function booted(): void
    {
        static::creating(function ($user) {
            $user->user_type ??= 'hr';
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *aa
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function questionScores()
    {
        return $this->hasMany(UserQuestionScore::class);
    }

    public function totalScore(): int
    {
        return $this->questionScores()->sum('score');
    }
    // User.php modelində
     
    public function isHr(): bool
    {
        return $this->user_type === 'hr';
    }

    public function isCourse(): bool
    {
        return $this->user_type === 'course';
    }

    public function isUser(): bool
    {
        return $this->user_type === 'user';
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'skill_user', 'user_id', 'skill_id');
    }
    public function interviews()
    {
        return $this->belongsToMany(VacancyApplicationInterview::class, 'interview_user');
    }

    public function wishlistedVacancies()
{
    return $this->belongsToMany(Vacancy::class, 'wishlist_jobs', 'user_id', 'vacancy_id');
}

    public function workExperiences()
    {
        return $this->hasMany(UserWorkExperience::class);
    }
    public function educations()
    {
        return $this->hasMany(UserEducation::class);
    }
    public function socialLinks()
    {
        return $this->hasMany(UserSocial::class);
    }



}
