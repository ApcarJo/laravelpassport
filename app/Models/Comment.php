<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    public function party(){
        return $this->belongsTo(Party::class);
    }

    public function player(){
        return $this->belongsTo(Player::class);
    }

    use HasFactory;
    
}
