<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){
        // You cannot follow yourself
        if($user->id == auth()->user()->id){
            return back()->with('failure', 'You cannot follow yourself.');
        }
        // You cannot follow someone you're already following
        $existCheck = Follow::where([
            ['user_id', '=', auth()->user()->id],
            ['followed_user', '=', $user->id],
        ])->exists();
        if($existCheck){
            return back()->with('failure', 'You are already following this user.');
        }
        // This is his way but I don't like it so I use another way
        /*
            $newFollow = new Follow();
            $newFollow->user_id = auth()->user()->id;
            $newFollow->followed_user = $user->id;
            $newFollow->save();
        */

        // my way of doing that
        Follow::create([
            'user_id'=> auth()->user()->id,
            'followed_user'=>$user->id,
        ]);

        return back()->with('success', 'User successfully followed.');
    
    }

    public function removeFollow(){

    }
}
