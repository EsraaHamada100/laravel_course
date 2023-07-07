<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function storeAvatar(Request $request){
        // here we said that the file is required and must be an image
        // and the size of that file shouldn't exceed 3000 KB
        $request->validate([
            'avatar'=>'required|image|max:3000',
        ]);
        /**
         * file('avatar) -> must be the same as the name of input tag in avatar-form
         * here fit 120 means to make the image 120*120 px 
         * encode('jpg') -> means to convert the type of image to jpg
        */
        $imgData = Image::make($request->file('avatar'))->fit('120')->encode('jpg');

        // making a unique name for our image
        $user = auth()->user();
        $filename = $user->id.'-'.uniqid().'.jpg';

        $oldAvatar = $user->avatar;
        // we will use this instead of $request->file('avatar')->store('public/avatars');
        // to upload the resized image
        Storage::put('public/avatars/'. $filename, $imgData);
        
        // to save the avatar fileName in the database
        $user->avatar = $filename;
        $user->save();

        // we make these to delete the old avatar when the user upload a new one

        // that means there is an avatar that user uploaded before
        if($oldAvatar != 'fallback-avatar.jpg'){
            // when we delete we should use the database path public/avatars/imageName
            // instead of the URL path storage/avatars/imageName
            $avatarDatabasePath = str_replace('/storage/', 'public/' , $oldAvatar);
            Storage::delete($avatarDatabasePath);
        }
        return back()->with('success', 'Congrats on the new avatar.');
    }
    public function showAvatarForm(){
        return view('avatar-form');
    }
    private function getSharedData($user){
        $currentlyFollowing = false;
        // if he is logged in
        if(auth()->check()){
            $currentlyFollowing = Follow::where([
                ['user_id', '=', auth()->user()->id],
                ['followed_user', '=', $user->id],
            ])->exists();
        }
        $posts = $user->posts();
        // send the data I wanna to send in a map or as we name it in php associated array
        View::share(
            'sharedData',
            [
                'currentlyFollowing'=> $currentlyFollowing,
                'username'=> $user->username,'avatar'=> $user->avatar, 
                'postCount'=> $posts->count(),
                'followerCount'=> $user->followers()->count(),
                'followingCount'=> $user->followingTheseUsers()->count(),
            ]
        );
    }
    public function profile(User $user){
        $this->getSharedData($user);
        // we call the function posts() from the user model to get the user posts
        // I use latest to make the newest post at the top 
        $posts = $user->posts()->latest()->get();
        return view('profile-posts', ['posts'=> $posts]);
    }

    public function profileFollowers(User $user){
        $this->getSharedData($user);
        $followers = $user->followers()->latest()->get();
        return view('profile-followers', ['followers'=> $followers]);
    }

    public function profileFollowing(User $user){
        $this->getSharedData($user);
        $followingTheseUsers = $user->followingTheseUsers()->latest()->get();
        return view('profile-following', ['followingTheseUsers'=> $followingTheseUsers]);
    }

    public function logout(){
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage(){
        $isLoggedIn = auth()->check();
        if($isLoggedIn){
            return view(
                'homepage-feed', 
                [
                    // to show posts in pages if they are long every page has 4 posts
                    'posts'=> auth()->user()->feedPosts()->latest()->paginate(4)
                ]
            );
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
