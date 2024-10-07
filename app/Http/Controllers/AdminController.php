<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Poster;
use App\models\Genre;

class AdminController extends Controller
{
    // создание поста
    public function index()
    {
        $genres = Genre::all(); 
        $posters = Poster::orderBy('created_at', 'DESC')->get();
        return view('adminPanel', ['posters' => $posters], compact('genres'));
    }

    public function showForm()
    {
        $genres = Genre::all(); // Получаем все жанры
        return view('posters.create', compact('genres'));
    }

    public function new_poster(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'photo' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048',
            'genres' => 'required|array',
        ]);

        $name = time() . "." . $request->photo->extension();
        $destination = 'public/';
        $path = $request->photo->storeAs($destination, $name);

        $info = [
            'name' => $request->name,
            'description' => $request->description,
            'image' => 'storage/' . $name,
        ];

        $poster = Poster::firstOrCreate(['name' => $info['name']], $info);

        if ($poster->wasRecentlyCreated) {
            $poster->genres()->sync($request->genres);
            return redirect()->back()->with('success', 'Постер успешно создан');
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
        // Валидация входящих данных
        $request->validate([
            'name' => 'string|max:255|unique:posters,name,' . $poster_id,
            'description' => 'string'
        ]);

        // Находим постер по ID
        $poster = Poster::find($poster_id);

        // Проверяем, существует ли постер
        if (!$poster) {
            return redirect()->back()->with('error', 'Постер не найден.');
        }

        // Обновляем поля только если они присутствуют в запросе
        if ($request->has('name')) {
            $poster->name = $request->name;
        }

        if ($request->has('description')) {
            $poster->description = $request->description;
        }

        // Сохраняем изменения
        $poster->save();

        // Возвращаемся на предыдущую страницу с сообщением об успехе
        return redirect()->back()->with('success', 'Постер успешно обновлён.');
    }
}
