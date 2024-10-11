<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analytic extends Model
{
    protected $fillable = [
        'event_type',
        'event_value',
        'user_id',
        'user_agent',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}