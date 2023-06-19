<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homePage(){

        $myName = 'Esraa Hamada';
        $animals = ['cat', 'dog', 'elephant'];
        // This is how you can pass parameters to the view
        return view('homepage', ['name'=> $myName, 'catName'=>'Meowsalot', 'allAnimals'=>$animals]);
    }

    public function aboutPage() {
        return view('single-post');
    }
}
