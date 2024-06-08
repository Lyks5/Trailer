<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Poster;

class AdminController extends Controller
{
    public function index()
    {
        $posters = Poster::orderBy('created_at', 'DESC')->get();
        return view('adminPanel', ['posters' => $posters]);    
    }
    public function new_poster(Request $request) {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $name = time(). "." . $request->photo->extension();
        $destination = 'public/';
        $path = $request->photo->storeAs($destination, $name);
        $info = [
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'storage/' . $name,
        ];
        Poster::create($info);
        return redirect()->back();
    }
    public function delete_post($post_id)
    {
        Poster::where('id', $post_id)->delete();
        return redirect()->back();
    }
    public function edit_poster($post_id)
    {
        $poster = Poster::where('id', $post_id)->first();
        return view('editPost', ['poster' => $poster]);
    }
    public function save_edit($poster_id, Request $request)
    {
        $request->validate([
            'name' => 'string|max:255',
            'description' => 'string'
        ]);
    
        $poster = Poster::find($poster_id);
    
        if ($request->has('name')) {
            $poster->name = $request->name;
        }
    
        if ($request->has('description')) {
            $poster->description = $request->description;
        }
    
        $poster->save();
    
        return redirect()->back();
    }
}
