<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'gameTitle',
        'thumbnail_url',
        'url'
    ];

    protected $hidden = [
        'isActive',
        'dateDeleted'
    ];

    public function party(){
        return $this->hasMany(Party::class);
    }

    use HasFactory;
}
