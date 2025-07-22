<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserSocial extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'user_socials';

    protected $fillable = [
        'user_id',
        'platform',
        'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
