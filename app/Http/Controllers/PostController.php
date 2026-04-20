<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::query();

        // search
        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // viewer → only published posts
        if (auth()->user()->role === 'viewer') {
            $query->where('status', 'published');
        }

        $posts = $query->latest()->paginate(5);

     

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully!');
    }

    public function show(Post $post)
    {
        $post->increment('views');

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
        ]);

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->route('posts.index')
            ->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    
}