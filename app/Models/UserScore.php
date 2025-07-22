<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserScore extends Model
{
    protected $fillable = ['user_id', 'score', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
