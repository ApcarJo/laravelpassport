<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function subscription(){
        return $this->hasMany(Subscription::class);
    }

    public function player(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
