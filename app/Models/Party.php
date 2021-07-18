<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{

    protected $fillable = [
        'partyName',
        'game_id',
        'owner_id'
    ];

    protected $hidden = [
        'isActive'        
    ];

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function comment(){
        return $this->hasMany(Comment::class);
    }

    public function subscription(){
        return $this->hasMany(Subscription::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    use HasFactory;
}
