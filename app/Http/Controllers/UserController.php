<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function profile(User $user){
        // we call the function posts() from the user model to get the user posts
        // I use latest to make the newest post at the top 
        $posts = $user->posts()->latest()->get();
        return view('profile-posts', ['username'=> $user->username, 'posts'=> $posts, 'postCount'=> $posts->count()]);
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage(){
        $isLoggedIn = auth()->check();
        if($isLoggedIn){
            return view('homepage-feed');
        }else {
            return view('homepage');
        }
    }

    public function login(Request $request){
        // here in the key you should write the name of the field
        $incomingField = $request->validate([
            'loginusername'=>'required',
             'loginpassword'=>'required',
        ]);
        // The auth()->attempt() function attempts to authenticate a user with the given credentials.
        $successfulLogin = auth()->attempt([
            'username'=>$incomingField['loginusername'],
             'password'=>$incomingField['loginpassword'],
        ]);

        if($successfulLogin){
            // this line regenerate the session which make the user still logged in
            // it stores cookies
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in .');
        }else {
            return redirect('/')->with('failure', 'Invalid login.');
        }

        
    }
    public function register(Request $request){
        $incomingField = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            // this confirmed text will make sure that the password_confirmation
            // match the password it self but you should name the field anything_confirmation
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        // hashing the password
        $incomingField['password'] = bcrypt($incomingField['password']);

        // create a new record in the users table, and will return the user data
        // but without the password
        $user = User::create($incomingField);
        echo $user;
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account');
    }
}
