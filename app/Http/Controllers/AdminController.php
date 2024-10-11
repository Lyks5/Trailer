<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Poster;
use App\models\Genre;
use App\Models\User;
use App\Models\Comment;
use App\Models\Like;
use App\Models\View;
use App\Models\Rating;
use App\Models\Analytic;
use Illuminate\Support\Facades\DB;
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
        'genres' => 'required',
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
        // Преобразуем строку жанров в массив
        $genresArray = explode(',', $request->genres);
        $poster->genres()->sync($genresArray);
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
    
    public function stat()
    {
        $totalPosts = Poster::count();
        $totalComments = Comment::count();
        $totalUsers = User::count();
        $totalViews = Poster::sum('views');
        $averageRating = Rating::avg('rank');

        // Данные для графиков
        $postsByMonth = $this->getPostsByMonth();
        $commentsByMonth = $this->getCommentsByMonth();
        $analyticsData = $this->getAnalyticsData();

        // Проверка данных
        if (empty($postsByMonth['labels']) || empty($postsByMonth['data'])) {
            $postsByMonth = ['labels' => [], 'data' => []];
        }

        if (empty($commentsByMonth['labels']) || empty($commentsByMonth['data'])) {
            $commentsByMonth = ['labels' => [], 'data' => []];
        }

        if (empty($analyticsData['pageViews']) && empty($analyticsData['linkClicks']) && empty($analyticsData['timeOnSite'])) {
            $analyticsData = ['pageViews' => 0, 'linkClicks' => 0, 'timeOnSite' => 0];
        }

        return view('stat', compact(
            'totalPosts',
            'totalComments',
            'totalUsers',
            'totalViews',
            'averageRating',
            'postsByMonth',
            'commentsByMonth',
            'analyticsData'
        ));
    }

    private function getPostsByMonth()
    {
        $posts = Poster::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $posts->pluck('month'),
            'data' => $posts->pluck('count')
        ];
    }

    private function getCommentsByMonth()
    {
        $comments = Comment::select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('COUNT(*) as count'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $comments->pluck('month'),
            'data' => $comments->pluck('count')
        ];
    }

    private function getAnalyticsData()
    {
        $pageViews = Analytic::where('event_type', 'page_view')->count();
        $linkClicks = Analytic::where('event_type', 'link_click')->count();
        $timeOnSite = Analytic::where('event_type', 'time_on_site')->count();

        return [
            'pageViews' => $pageViews,
            'linkClicks' => $linkClicks,
            'timeOnSite' => $timeOnSite
        ];
    }
    
}
