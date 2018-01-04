<?php

namespace Genv\Web\Web\Controllers;

use Genv\Otc\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostsFeedController extends Controller
{
    /**
     * Show the rss feed of posts.
     *
     * @return Response
     */
    public function index()
    {
        $posts = Cache::remember('feed-posts', 60, function () {
            return Post::latest()->limit(20)->get();
        });

        return response()->view('posts.feed.index', [
            'posts' => $posts
        ], 200)->header('Content-Type', 'text/xml');
    }
}
