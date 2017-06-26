<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile($slug)
    {
        $user = User::where('slug',$slug)->first();
        return view('profiles.profile',compact('user'));
    }
}
