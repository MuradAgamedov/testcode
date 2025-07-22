<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacancyTechnicalTask extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'vacancy_id',
        'file_path',
    ];
    protected $appends = ['file_url'];

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . ltrim($this->file_path, '/'));
    }

}
