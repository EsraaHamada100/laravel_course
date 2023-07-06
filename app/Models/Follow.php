<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'followed_user'];

    public function userDoingTheFollowing(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function userBeingFollowed(){
        return $this->belongsTo(User::class, 'followed_user');
    }
}
