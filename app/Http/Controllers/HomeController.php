<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;
use App\Models\Genre;
use Auth;

class HomeController extends Controller
{
    // Личный кабинет
    public function index()
    {
        $like = Like::with('poster')->where('user_id', Auth::user()->id)->get();
        return view('home', ['like' => $like]);
    }

    // Показ главной страницы
    public function welcome()
    {
        $posts = Poster::where('visibility', 1)->limit(10)->get();
        return view('welcome', ['posts' => $posts]);
    }



    public function post($post_id)
    {
        // Получаем постер по ID
        $poster = Poster::findOrFail($post_id);

        // Получаем уникальный идентификатор пользователя (ID или IP-адрес)
        $userId = Auth::check() ? Auth::user()->id : request()->ip();

        // Проверяем, был ли уже просмотр
        if (!View::where('poster_id', $poster->id)->where('user_id', $userId)->exists()) {
            // Добавляем новый просмотр
            View::create([
                'poster_id' => $poster->id,
                'user_id' => $userId,
            ]);

            // Увеличиваем счётчик просмотров
            $poster->increment('views');
        }

        // Получаем лайк пользователя для данного постера
        $like = Like::where('user_id', Auth::user()->id)->where('poster_id', $post_id)->first();

        // Возвращаем представление с данными постера и комментариями
        return view('post', [
            'post' => $poster, // Используем уже полученный объект $poster
            //Модель коммент получает из моделей пост и юзер их id, фильтрует (orderBy) от новых к старым
            'comments' => Comment::with(['post', 'user'])->where('poster_id', $post_id)->orderBy('created_at', 'DESC')->get(),

            'like' => $like,
        ]);
    }



    // Поиск
    public function search(Request $request)
    {
        // Получаем слово для поиска из запроса
        $word = $request->word;

        // Ищем постеры, где имя или описание содержит слово
        // Результаты сортируются по ID в порядке возрастания
        $results = Poster::where('name', 'like', "%{$word}%")
            ->Where('visibility', '1')
            ->orderBy('id')
            ->get();

        // Возвращаем представление 'search' с найденными постерами
        return view('search', ['posts' => $results]);
    }

    // Страница Что посмотреть
    public function see(Request $request)
    {
        // Получаем все жанры
        $genres = Genre::pluck('name')->unique()->values()->all();

        // Получаем параметр жанра из запроса
        $genre = $request->input('genre');

        // Если жанр указан, фильтруем по нему, иначе выбираем случайные постеры
        if ($genre) {
            $posts = Poster::whereHas('genres', function ($query) use ($genre) {
                $query->where('name', $genre);
            })->inRandomOrder()->limit(15)->get();
        } else {
            $posts = Poster::inRandomOrder()->limit(15)->get();
        }

        // Возвращаем представление 'see' с полученными постерами и жанрами
        return view('see', [
            'posts' => $posts,
            'genres' => $genres,
        ]);
    }

    // Страница Рейтинг
    public function rating()
    {
        // Получаем 10 постеров, отсортированных по количеству просмотров в порядке убывания
        $posts = Poster::where('visibility', 1)
            ->orderBy('views', 'desc')
            ->limit(10)
            ->get();

        return view('rating', ['posts' => $posts]);
    }

    // Добавление нового комментария
    public function new_comment($id, Request $request)
    {
        // Создаем новый комментарий с ID пользователя, ID постера и текстом сообщения
        Comment::create([
            'user_id' => Auth::user()->id, // Получаем ID текущего аутентифицированного пользователя
            'poster_id' => $id,             // ID постера, к которому добавляется комментарий
            'message' => $request->message  // Сообщение из инпута
        ]);


        return redirect()->back();
    }

    // Добавление в избранное (лайк)
    public function add_liked($product_id)
    {
        // Проверяем, добавлен ли в избранное от текущего пользователя к данному постеру
        $status = Like::where('user_id', Auth::user()->id)
            ->where('poster_id', $product_id)
            ->first();

        if ($status) {
            // Если в избранном уже существует, удаляем его
            Like::where('id', $status->id)->delete();
        } else {
            // Если в избранном нет, добавляем в избранное с ID пользователя и постера
            $data = [
                'user_id' => Auth::user()->id,
                'poster_id' => $product_id,
            ];
            Like::create($data);
        }

        return redirect()->back();
    }
}