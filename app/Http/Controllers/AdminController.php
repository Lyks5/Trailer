<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('adminPanel');    
    }
    public function new_poster(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|mimes:mp4'
        ]);

        $name = time(). "." . $request->photo->extension();
        $destination = 'public/';
        $path = $request->photo->storeAs($destination, $name);
        $info = [
            'name' => $request->name,
            'description' => $request->description,
            'photo' => 'storage/' . $name,
        ];
        Poster::create($info);
        return redirect()->back();
    }
}
