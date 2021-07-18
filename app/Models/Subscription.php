<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    protected $fillable = [
        'party_id',
        'user_id'
    ];

    public function party(){
        return $this->belongsTo(Party::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    use HasFactory;
}
