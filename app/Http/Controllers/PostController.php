<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

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
        Post::create($incomingFields);
        return 'you have created new post';
    }
    public function showCreateForm(){
        return view('create-post');
    }
}
