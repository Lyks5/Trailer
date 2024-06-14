<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poster;
use App\Models\Comment;
use App\Models\Like;
use Auth;

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
        $like = Like::with('poster')->where('user_id', Auth::user()->id)->get();
        return view('home', ['like' => $like]);
    }
    public function welcome()
    {
       
        $posts = Poster::where('visibility', 1)->limit(10)->get();
        return view('welcome', ['posts' => $posts]);
    }
    public function post($post_id)
    {
        $post = Poster::where('id', $post_id)->first();
        $like = Like::where('user_id', Auth::user()->id)->where('poster_id', $post_id)->first();
        return view('post', ['post' => $post, 'comments' => Comment::with(['post', 'user'])->where('poster_id', $post_id)->orderBy('created_at', 'DESC')->get(), 'like' => $like]);
    }
    public function search(Request $request)
    {
        $word = $request->word;
        $results = Poster::where('name', 'like', "%{$word}%")->orWhere('description', 'like', "%{$word}%")->orderBy('id')->get();
        return view('search', ['posts' => $results]);
    }
    public function see()
    {  
        $posts = Poster::where('visibility', 1)->inRandomOrder()->limit(15)->get();
        return view('see', ['posts' => $posts]);
    }

    public function new_comment($id, Request $request)
    {
        Comment::create([
            'user_id' => Auth::user()->id,
            'poster_id' => $id,
            'message' => $request->message
        ]);
        return redirect()->back();
    }
    public function add_liked($product_id)
    {
        // Добавление в избранное
        $status = Like::where('user_id', Auth::user()->id)->where('poster_id', $product_id)->first();
        if ($status) {
            Like::where('id', $status->id)->delete();
        }
        else {
            $data = [
                'user_id' => Auth::user()->id,
                'poster_id' => $product_id,
            ];
            Like::create($data);
        }
        return redirect()->back();
    }
}
