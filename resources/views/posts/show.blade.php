@extends('layouts.app')

@section('content')

<h1 class="text-2xl font-bold">{{ $post->title }}</h1>

<p>{{ $post->content }}</p>

<p>Status: {{ $post->status }}</p>

<a href="/posts">← Back</a>

@endsection