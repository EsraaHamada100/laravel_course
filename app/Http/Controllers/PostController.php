<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * here we see the power of laravel because in laravel if you match
     * the name in web.php and this name and write the model it will 
     * automatically go to database and get the post with this id
     * else if you don't write the same name nor Post this will be the id as usual 
     */
    public function viewSinglePost(Post $post){
        return view('single-post', ['post'=> $post]);
    }

    public function storeNewPost(Request $request){
        $incomingFields = $request->validate([
            'title'=> 'required',
            'body'=> 'required',
        ]);
        // The code is removing any HTML tags , so that no one can inject these tags to
        // perform any kind of attack
        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();
        // This will create new post record in database with the data in the $incomingFields
        $newPost = Post::create($incomingFields);
        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created.');
    }
    public function showCreateForm(){
        return view('create-post');
    }
}
