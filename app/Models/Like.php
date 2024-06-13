<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'poster_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
    public function poster()
    {
        return $this->hasMany(Poster::class, 'id', 'poster_id');
    }
}
