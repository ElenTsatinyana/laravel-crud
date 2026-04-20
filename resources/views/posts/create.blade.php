@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold mb-4">Create Post</h1>

<form action="/posts" method="POST" class="bg-white p-6 rounded shadow">
    @csrf

    <div class="mb-4">
        <label class="block mb-1">Title</label>
        <input type="text" name="title" class="w-full border p-2 rounded">
    </div>

    <div class="mb-4">
        <label class="block mb-1">Content</label>
        <textarea name="content" class="w-full border p-2 rounded"></textarea>
    </div>

    <div class="mb-4">
        <label class="block mb-1">Status</label>
        <select name="status" class="w-full border p-2 rounded">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>
    </div>

    <button class="bg-green-500 text-white px-4 py-2 rounded">
        Save
    </button>
</form>

@endsection