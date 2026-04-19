<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_published', true)->with('user')->latest()->paginate(12);
        return view('posts.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $relatedPosts = Post::where('id', '!=', $post->id)
                            ->where('is_published', true)
                            ->latest()
                            ->take(3)
                            ->get();
                            
        return view('posts.show', compact('post', 'relatedPosts'));
    }
}
