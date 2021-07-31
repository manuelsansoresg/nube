<?php

namespace App\Http\Controllers;

use App\Models\Discover;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function welcome()
    {
        if(Auth::id()){
            $user    = Arr::first(User::random());
            $path    = 'img/profile';
            $users   = Discover::top();
            $my_user = User::myUser(Auth::id());

            return view('landing', compact('user', 'path', 'users', 'my_user'));
        }else{
            return view('welcome');
        }
    }
}
