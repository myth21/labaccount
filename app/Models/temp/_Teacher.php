<?php

namespace App\Models;

use App\User;
use Illuminate\Notifications\Notifiable;

class _Teacher extends Model
{
    use Notifiable;

    protected $guarded = [];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
