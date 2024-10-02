<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Poster;

class AdminController extends Controller
{
    // создание поста
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
        $poster = Poster::firstOrCreate(['name' => $info['name']], $info);
        if ($poster->wasRecentlyCreated) {
            return redirect()->back();
        } else {
            return redirect()->back()->withErrors(['error' => 'Такой постер уже существует']);
        }
    }
    // Функция скрытия 
    public function hide($id)
    {
        $post = Poster::find($id);

        if (!$post) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        // Устанавливаем visibility в 0
        $post->visibility = 0;
        $post->save();

        return redirect()->back();
    }
    // Функция востановления
    public function restore($id)
{
    $post = Poster::find($id);

    if (!$post) {
        return response()->json(['message' => 'Item not found'], 404);
    }

    // Устанавливаем visibility в 1
    $post->visibility = 1;
    $post->save();

    return redirect()->back();
}
    // Редактирование поста
    public function edit_poster($post_id)
    {
        $poster = Poster::where('id', $post_id)->first();
        return view('editPost', ['poster' => $poster]);
    }
    // Сохранение изменений
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
