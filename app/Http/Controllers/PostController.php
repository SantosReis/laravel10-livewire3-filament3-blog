<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function index()
    {

        $categories = Cache::remember('categories', now()->addDays(3), function () {
            return Category::whereHas('posts', function ($query) {
                $query->published();
            })->take(10)->get();
        });

        return view('posts.index',
            [
                // 'posts' => Post::take(5)->get(),
                'categories' => $categories,
            ]
        );
    }

    public function show(Post $post)
    {
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id')->first();
        $previousPost = Post::where('id', '<', $post->id)->orderByDesc('id')->first();

        return view(
            'posts.show',
            [
                'post' => $post,
                'nextPost' => $nextPost,
                'previousPost' => $previousPost,
            ]
        );
    }
}
