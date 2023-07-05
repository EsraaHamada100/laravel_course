<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
            return $value?'/storage/avatars/'. $value : 'fallback-avatar.jpg';
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
}
