<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function welcome()
    {
        $posts = Poster::where('visibility', 1)->limit(10)->get();
        return view('welcome', ['posts' => $posts]);
    }
    public function post($post_id)
    {
        $post = Poster::where('id', $post_id)->first();
        return view('post', ['post' => $post]);
    }
    public function search(Request $request)
    {
        $word = $request->word;
        $results = Poster::where('name', 'like', "%{$word}%")->orWhere('description', 'like', "%{$word}%")->orderBy('id')->get();
        return view('search', ['posts' => $results]);
    }
}
