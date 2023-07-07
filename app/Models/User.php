<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Follow;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * This function is called an accessor.
     * It allows you to retrieve and manipulate the value of an attribute on the model.
     * The name of the function should be the same as the name of the attribute
     * you want to manipulate.
     */
    protected function avatar(): Attribute{
        return Attribute::make(get: function($value){
            return $value?'/storage/avatars/'. $value : '/fallback-avatar.jpg';
        });
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // define the relation between the user and posts from the user perspective
    public function posts(){
        // it takes 2 arguments the class and the column in post that make the relationship
        return $this->hasMany(Post::class, 'user_id');
    }

    public function followers(){
        return $this->hasMany(Follow::class, 'followed_user');
    }

    public function followingTheseUsers(){
        return $this->hasMany(Follow::class, 'user_id');
    }

    public function feedPosts(){
        /**
         * We user hasManyThrough is we want to retrieve something from a table that
         * that is linked to intermediate table so from our table to the intermediate table
         * which than lead to the target table, hope it's clear now.
         * first arg : It's the Model of the Goal table that we wanna retrieve it's data
         * second arg : It's the Model of the intermediate table
         * third arg : the foreign key of the intermediate table
         * fourth arg : the foreign key of the target table
         * fifth arg : The primary key of our local table here it's Users table
         * sixth arg : The primary key of the target table and actually it's not the primary key
         * it's only the field that we are interested in.
         */
        return $this->hasManyThrough(Post::class, Follow::class, 'user_id', 'user_id', 'id', 'followed_user');
    }
    
}
