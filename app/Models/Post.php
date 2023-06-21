<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    /**
     *   This prevents user from mass assignment to any field other than theses
     * and that is for security reasons if you want to add another field you should 
     * add it individually by a setter function.
     *   Mass assignment is a way of setting multiple attributes on a model at once,
     *  using an array of key-value pairs. 
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
    ];
}
