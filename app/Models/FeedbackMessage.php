<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class FeedbackMessage extends Model
{

    protected $fillable = [
        'name',
        'email',
        'role',
        'message',
    ];
}
