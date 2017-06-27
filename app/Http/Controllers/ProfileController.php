<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile($slug)
    {
        $user = User::where('slug',$slug)->first();
        return view('profiles.profile',compact('user'));
    }

    public function update($slug,Request $request)
    {
        $project = User::where('slug',$slug)->first()->profile;
        $project->about = $request->about;
        $project->position = $request->position;
        $project->save();
        return $project;
    }
}
