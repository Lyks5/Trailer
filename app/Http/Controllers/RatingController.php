<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Poster;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $poster_id)
    {
        $request->validate([
            'rank' => 'required|integer|min:1|max:10', // Измените здесь на rank
        ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'poster_id' => $poster_id],
            ['rating' => $request->rank] // Измените здесь на rank
        );

        return redirect()->back()->with('success', 'Ваша оценка сохранена.');
    }

    public function show($poster_id)
    {
        $poster = Poster::findOrFail($poster_id);
        $ratings = $poster->ratings()->with('user')->get();
        $averageRating = $poster->ratings()->avg('rating');
        $userRating = $this->getUserRating($poster_id); // Получаем текущую оценку пользователя
        dd($userRating);

        // Передаем переменные в представление post.blade.php
        return view('post', compact('poster', 'ratings', 'averageRating', 'userRating'));
    }

    public function getUserRating($poster_id)
    {
        if (Auth::check()) {
            $userRating = Rating::where('user_id', Auth::id())
                ->where('poster_id', $poster_id)
                ->first();
            return $userRating ? $userRating->rating : null;
        }
        return null;
    }
}