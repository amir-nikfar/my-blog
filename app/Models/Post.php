<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['post_image', 'title', 'body', 'user_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function rate(){
        return $this->hasMany(Ratings::class);
    }
}
