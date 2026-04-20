<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| AUTH + OTP
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/become-editor', function () {
        return view('become-editor');
    })->name('become.editor');

    Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('otp.send');

    Route::get('/verify-otp', function () {
        return view('verify-otp');
    })->name('otp.verify.form');

    Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role !== 'admin') {
        if ($user->role === 'editor') {
            return redirect()->route('posts.create');
        }
        return redirect()->route('posts.index');
    }

    $totalPosts = Post::count();
    $publishedPosts = Post::where('status', 'Published')->count();
    $draftPosts = Post::where('status', 'Draft')->count();
    $myPosts = Post::where('user_id', auth()->id())->count();

    $postsPerMonth = Post::select(
            DB::raw("DATE_FORMAT(created_at, '%b') as month"),
            DB::raw('count(*) as count')
        )
        ->groupBy('month')
        ->orderBy('created_at')
        ->get();


    $mostViewed = Post::orderBy('views', 'desc')->take(5)->get();

    $postsByStatus = Post::groupBy('status')
        ->select('status', DB::raw('count(*) as count'))
        ->pluck('count', 'status')
        ->toArray();


    $usersByRole = User::groupBy('role')
        ->select('role', DB::raw('count(*) as count'))
        ->pluck('count', 'role');


    $categoryDistribution = $postsByStatus; 

    return view('dashboard', compact(
        'totalPosts', 
        'publishedPosts', 
        'draftPosts', 
        'myPosts', 
        'postsPerMonth',
        'mostViewed',
        'postsByStatus',
        'usersByRole',
        'categoryDistribution'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| POSTS
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // ALL USERS
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

    // ADMIN + EDITOR — ⚠️ պետք է լինի {post}-ից ԱՌԱՋ
    Route::middleware(['role:admin,editor'])->group(function () {
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    });

    // ALL USERS — {post} վերջում
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

    // ONLY ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    });

});

require __DIR__.'/auth.php';