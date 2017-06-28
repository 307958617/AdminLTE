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
        $data = $request->input('img');
        list($type,$data) = explode(';',$data);
        list(, $data) = explode(',', $data);
        $data = base64_decode($data);
        $imageName = time().'.png';
        $path = public_path('images/avatars/');
        if(!file_exists($path)){
            mkdir($path,0755,true);
        }
        file_put_contents($path.$imageName,$data);


//        $project = User::where('slug',$slug)->first()->profile;
//        $project->about = $request->about;
//        $project->position = $request->position;
//        $project->save();
//        return $project;
    }
}
