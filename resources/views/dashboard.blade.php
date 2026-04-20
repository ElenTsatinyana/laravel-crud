@extends('layouts.app')

@section('content')

    @if(auth()->user()->role === 'admin')
    <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-lg">
        <h2 class="text-lg font-bold text-red-700">Admin Panel</h2>
        <div class="flex gap-4 mt-3">
            <a href="{{ route('posts.index') }}" class="bg-red-600 text-white px-4 py-2 rounded">Manage Posts</a>
            <a href="/dashboard" class="bg-gray-800 text-white px-4 py-2 rounded">Refresh Stats</a>
        </div>
    </div>
    <div class="mb-6 text-sm text-gray-500">
        🔥 You are logged in as <b>Admin</b>
    </div>
    @endif

    <!-- STAT CARDS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-gray-500 text-sm">Total Posts</p>
            <h3 class="text-2xl font-bold text-gray-900">{{ $totalPosts }}</h3>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-gray-500 text-sm">Published</p>
            <h3 class="text-2xl font-bold text-green-600">{{ $publishedPosts }}</h3>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-gray-500 text-sm">Draft</p>
            <h3 class="text-2xl font-bold text-yellow-500">{{ $draftPosts }}</h3>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <p class="text-gray-500 text-sm">My Posts</p>
            <h3 class="text-2xl font-bold text-blue-500">{{ $myPosts }}</h3>
        </div>
    </div>

    <!-- CHARTS ROW 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-md font-semibold text-gray-700 mb-4">📊 Posts Created (Last 6 Months)</h4>
            <canvas id="barChart"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-md font-semibold text-gray-700 mb-4">👁️ Most Viewed Posts</h4>
            <canvas id="lineChart"></canvas>
        </div>
    </div>

    <!-- CHARTS ROW 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-md font-semibold text-gray-700 mb-4">📝 Posts by Status</h4>
            <canvas id="pieChart" style="max-height: 260px;"></canvas>
        </div>
        <div class="bg-white shadow rounded-lg p-6">
            <h4 class="text-md font-semibold text-gray-700 mb-4">👥 Users by Role</h4>
            <canvas id="donutChart" style="max-height: 260px;"></canvas>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const barCtx = document.getElementById('barChart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: @json($postsPerMonth->pluck('month')),
                datasets: [{
                    label: 'Posts',
                    data: @json($postsPerMonth->pluck('count')),
                    backgroundColor: 'rgba(99, 102, 241, 0.7)',
                    borderRadius: 6,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const lineCtx = document.getElementById('lineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: @json($mostViewed->pluck('title')),
                datasets: [{
                    label: 'Views',
                    data: @json($mostViewed->pluck('views')),
                    borderColor: 'rgba(16, 185, 129, 1)',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: { responsive: true, plugins: { legend: { display: false } } }
        });

        const pieCtx = document.getElementById('pieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: @json(array_keys($postsByStatus)),
                datasets: [{
                    data: @json(array_values($postsByStatus)),
                    backgroundColor: ['rgba(16,185,129,0.8)', 'rgba(245,158,11,0.8)'],
                }]
            },
            options: { responsive: true }
        });

        const donutCtx = document.getElementById('donutChart').getContext('2d');
        new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: @json($usersByRole->keys()),
                datasets: [{
                    data: @json($usersByRole->values()),
                    backgroundColor: [
                        'rgba(239,68,68,0.8)',
                        'rgba(99,102,241,0.8)',
                        'rgba(156,163,175,0.8)'
                    ],
                }]
            },
            options: { responsive: true }
        });
    </script>

@endsection