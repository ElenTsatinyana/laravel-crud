@extends('layouts.app')

@section('content')

<!-- FLASH MESSAGE -->
@if(session('success'))
    <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
        {{ session('success') }}
    </div>
@endif



<!-- PAGE HEADER -->
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-900">Posts</h1>

    @can('create', App\Models\Post::class)
        <a href="{{ route('posts.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors duration-150">
            + Create Post
        </a>
    @endcan
</div>

<!-- SEARCH FORM -->
<div class="bg-white rounded-xl border border-gray-200 p-4 mb-4">
    <form method="GET" action="/posts" class="flex gap-2">

        <input 
            type="text" 
            name="search" 
            placeholder="Search posts..." 
            class="flex-1 border border-gray-200 bg-gray-50 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
            value="{{ request('search') }}"
        >

        <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium">
            Search
        </button>

        <a href="/posts" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-medium">
            Reset
        </a>

    </form>
</div>

<!-- TABLE -->
<div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full">

        <thead>
            <tr class="bg-gray-50 border-b border-gray-200">
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Content</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-gray-100">

            @forelse($posts as $post)
            <tr class="hover:bg-gray-50">

                <!-- TITLE -->
                <td class="px-4 py-3 font-medium text-gray-900">
                    {{ $post->title }}
                </td>

                <!-- CONTENT -->
                <td class="px-4 py-3 text-sm text-gray-500">
                    {{ Str::limit($post->content, 60) }}
                </td>

                <!-- STATUS -->
                <td class="px-4 py-3">
                    @if($post->status == 'published')
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                            Published
                        </span>
                    @else
                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-600">
                            Draft
                        </span>
                    @endif
                </td>

                <!-- ACTIONS -->
                <td class="px-4 py-3">
                    <div class="flex gap-3 items-center">

                        <!-- VIEW -->
                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm">
                            View
                        </a>

                        <!-- EDIT -->
                        @can('update', $post)
                            <a href="{{ route('posts.edit', $post->id) }}" 
                               class="text-green-600 hover:text-green-800 text-sm">
                                Edit
                            </a>
                        @endcan

                        <!-- DELETE -->
                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button 
                                    onclick="return confirm('Are you sure?')"
                                    class="text-red-600 hover:text-red-800 text-sm">
                                    Delete
                                </button>
                            </form>
                        @endcan

                    </div>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-10 text-gray-400">
                    No posts found
                </td>
            </tr>
            @endforelse

        </tbody>

    </table>
</div>



<!-- PAGINATION -->
<div class="mt-4">
    {{ $posts->links() }}
</div>

<script>
setInterval(async function () {
    let res = await fetch(window.location.href, {
        headers: { "X-Requested-With": "XMLHttpRequest" }
    });

    if (res.ok) {
        location.reload();
    }
}, 5000);
</script>

@endsection

