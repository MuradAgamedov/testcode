<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserWorkExperience extends Model
{
    use HasFactory, SoftDeletes;

    protected $table ='user_work_experience';

    protected $fillable = [
        'user_id',
        'role',
        'company_name',
        'description',
        'start_date',
        'end_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
