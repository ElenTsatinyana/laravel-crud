@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Edit Post</h1>

<form action="/posts/{{ $post->id }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="title" value="{{ $post->title }}" class="border p-2 w-full mb-2">

    <textarea name="content" class="border p-2 w-full mb-2">{{ $post->content }}</textarea>

    <select name="status" class="border p-2 w-full mb-2">
        <option value="draft" @selected($post->status=='draft')>Draft</option>
        <option value="published" @selected($post->status=='published')>Published</option>
    </select>

    <button class="bg-blue-500 text-white px-4 py-2">Update</button>
</form>

@endsection