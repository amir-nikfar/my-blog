<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratings extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'rating'];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
