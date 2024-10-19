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
use Carbon\Carbon;
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
        $lastLoginByDay = $this->getLastLoginByDay();

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
            'analyticsData',
            'lastLoginByDay'
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
        // Группируем просмотры по датам
        $pageViewsByDate = Analytic::where('event_type', 'page_view')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pageViews = $pageViewsByDate->sum('views'); // Общее количество просмотров
        $linkClicks = Analytic::where('event_type', 'link_click')->count();
        $timeOnSite = Analytic::where('event_type', 'time_on_site')->count();

        // Преобразуем данные для графиков
        $pageViewsData = $pageViewsByDate->pluck('views')->toArray();
        $pageViewsLabels = $pageViewsByDate->pluck('date')->toArray();

        return [
            'pageViews' => $pageViews,
            'pageViewsData' => $pageViewsData,
            'pageViewsLabels' => $pageViewsLabels,
            'linkClicks' => $linkClicks,
            'timeOnSite' => $timeOnSite
        ];
    }

    private function getLastLoginByDay()
    {
        $lastLoginByDay = User::select(
            DB::raw('DATE(last_login_at) as date'),
            DB::raw('COUNT(*) as count')
        )
            ->where('last_login_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $lastLoginByDayLabels = [];
        $lastLoginByDayData = [];

        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $lastLoginByDayLabels[] = $date;
            $lastLoginByDayData[] = $lastLoginByDay->firstWhere('date', $date)->count ?? 0;
        }

        return [
            'labels' => array_reverse($lastLoginByDayLabels),
            'data' => array_reverse($lastLoginByDayData),
        ];
    }
    public function users(Request $request)
    {
        $query = User::query();

        // Поиск по имени, email или ID
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('id', 'like', "%$search%");
            });
        }

        // Сортировка
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            $direction = $request->input('direction', 'asc');
            $query->orderBy($sort, $direction);
        }

        $users = $query->with(['comments', 'likes'])->get();

        return view('users', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return response()->json(['success' => true]);
    }

    public function toggleBlockUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users')->with('error', 'Пользователь не найден');
        }

        // Переключаем статус блокировки
        $user->blocked = !$user->blocked;
        $user->save();

        // Определяем сообщение в зависимости от действия
        $message = $user->blocked ? 'Пользователь успешно заблокирован' : 'Пользователь успешно разблокирован';

        return redirect()->route('users')->with('success', $message);
    }
    public function showUserDetails($id)
    {
        $user = User::findOrFail($id);
        // Получение дополнительной информации о пользователе (комментарии, избранные фильмы и т.д.)
        return view('admin.user_details', compact('user'));
    }

}
