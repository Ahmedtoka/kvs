<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'posts' => Post::published()->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        return view('news.show', [
            'post' => $post,
            'more' => Post::published()->where('id', '!=', $post->id)->limit(3)->get(),
        ]);
    }
}
