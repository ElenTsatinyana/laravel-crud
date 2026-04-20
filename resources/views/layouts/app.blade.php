<!DOCTYPE html>
<html>
<head>
    <title>Laravel CRUD System</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<nav class="bg-white shadow p-4 flex justify-between items-center">

    <!-- LEFT -->
    <div class="flex items-center gap-4">
        <div class="font-bold">{{ config('app.name', 'Default Name') }}</div>

        @if(auth()->user() && auth()->user()->role == 'admin')
        <a href="{{ route('dashboard') }}" 
           class="ml-4 px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
            🏠 Dashboard
        </a>
        @endif

        <a href="/posts">Posts</a>

        @if(auth()->user()->role != 'viewer')
            <a href="/posts/create">Create</a>
        @endif
    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-3">

        <span class="text-sm text-gray-600">
            {{ auth()->user()->name }} ({{ auth()->user()->role }})
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                Logout
            </button>

          
        </form>

        @if(auth()->user()->role === 'viewer')
            <a href="/become-editor" class="text-yellow-600 ml-4">
                Become Editor
            </a>
        @endif
    </div>
    

</nav>

<div class="container mx-auto mt-6">
    @yield('content')
</div>

</body>
</html>