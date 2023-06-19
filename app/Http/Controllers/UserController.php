<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function register(Request $request){
        $incomingField = $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
        // create a new record in the users table
        User::create($incomingField);
        return 'Hello from register function';
    }
}
