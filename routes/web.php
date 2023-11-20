<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocsController;
use App\Http\Controllers\CommentsController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\TurboStream;
use App\Http\Controllers\LikeController;
use App\Docs;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'pages.welcome')->name('home');
Route::view('/feature', 'pages.feature')->name('feature');
Route::view('/advertising', 'pages.advertising')->name('advertising');
Route::view('/resources', 'pages.resources')->name('resources');
Route::view('/meets', 'pages.meets')->name('meets');
Route::view('/performance', 'pages.performance')->name('performance');
Route::view('/team', 'pages.team')->name('team');
Route::view('/packages', 'pages.packages')->name('packages');
Route::view('/courses', 'pages.courses')->name('courses');
Route::view('/coming-soon', 'coming-soon')->name('coming-soon');


Route::get('/feed', [PostController::class, 'feed'])->name('feed');

Route::get('/posts', [PostController::class, 'list'])
    ->name('posts');

Route::post('/posts', [PostController::class, 'list'])
    ->middleware(\App\Http\Middleware\TurboStream::class);

/*
Route::prefix('/stream')->middleware(\App\Http\Middleware\TurboStream::class)->group(function () {
    Route::post('/posts', [PostController::class, 'list'])->name('post.load-more');
});
*/

Route::get('/p/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/comments/article/{post}', [CommentsController::class, 'show'])
    ->name('post.comments');


Route::middleware(['auth'])
    ->group(function () {
        Route::get('/posts/edit/{post?}', [PostController::class, 'edit'])->name('post.edit');
        Route::post('/posts/edit/{post?}', [PostController::class, 'edit'])
            ->middleware(\App\Http\Middleware\TurboStream::class);
        Route::post('/posts/update/{post?}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/posts/edit/{post}', [PostController::class, 'delete'])
            ->middleware(\App\Http\Middleware\TurboStream::class)
            ->name('post.delete');
    });


Route::middleware(['auth'])
    ->prefix('comments')
    ->group(function () {
        Route::post('/', [CommentsController::class, 'store'])
            ->name('comments.store');

        Route::post('/{comment}', [CommentsController::class, 'reply'])
            ->name('comments.reply');

        Route::put('/{comment}', [CommentsController::class, 'update'])
            ->name('comments.update');

        Route::delete('/{comment}', [CommentsController::class, 'delete'])
            ->name('comments.delete');

        Route::post('/{comment}/reply', [CommentsController::class, 'showReply'])->name('comments.show.reply');
        Route::post('/{comment}/edit', [CommentsController::class, 'showEdit'])->name('comments.show.edit');
    });


/*
|--------------------------------------------------------------------------
| User-Like Routes
|--------------------------------------------------------------------------
|
| This section contains the web routes related to user likes.
| These routes handle setting/unsetting likes for different entities.
|
*/

Route::middleware('auth')
    ->prefix('like')
    ->group(function () {
        Route::post('/post/{post}', [LikeController::class, 'togglePost'])
            ->name('like.post');

        Route::post('/comment/{comment}', [LikeController::class, 'toggleComment'])
            ->name('like.comment');
    });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| This section contains the web routes related to authentication.
| These routes handle user authentication and logout processes.
|
*/

Route::get('/auth/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/auth/callback', [AuthController::class, 'callback'])->middleware('guest');
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| Documentation Routes
|--------------------------------------------------------------------------
|
| This section contains the web routes for accessing the documentation.
| The routes handle redirects, display documentation pages, and provide related data.
|
*/
Route::view('/documentation-contribution-guide', 'docs.contribution')
    ->name('documentation-contribution-guide');

Route::redirect('/docs/', '/docs/' . Docs::DEFAULT_VERSION);

Route::get('/status/{version?}', [DocsController::class, 'status'])
    ->whereIn('version', Docs::SUPPORT_VERSIONS)
    ->name('status');

Route::get('/docs/{version?}/{page?}', [DocsController::class, 'show'])
    ->whereIn('version', Docs::SUPPORT_VERSIONS)
    ->name('docs');



/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
|
| TODO:
|
*/

Route::get('/user/{nickname}', function ($nickname){
    return $nickname;
})->name('user.show');

Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])
    ->middleware('auth')
    ->name('my');

Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('my.edit');

Route::post('/profile/update', [\App\Http\Controllers\ProfileController::class, 'update'])
    ->middleware('auth')
    ->middleware(\App\Http\Middleware\TurboStream::class)
    ->name('my.update');

Route::get('/profile/{user:nickname}',  [\App\Http\Controllers\ProfileController::class, 'show'])
    ->name('profile');

/*Route::get('/profile/{user:nickname}/posts',[\App\Http\Controllers\ProfileController::class,'postTab'])
    ->name('profile.posts');

Route::post('/profile/{user:nickname}/posts',[\App\Http\Controllers\ProfileController::class,'postTab'])
    ->middleware(\App\Http\Middleware\TurboStream::class);*/


Route::get('/profile/{user:nickname}/comments',[\App\Http\Controllers\ProfileController::class,'comments'])
    ->name('profile.comments');

Route::get('/profile/{user:nickname}/awards',[\App\Http\Controllers\ProfileController::class,'awards'])
    ->name('profile.awards');


/*
|--------------------------------------------------------------------------
| PWA/iOS Manifest
|--------------------------------------------------------------------------
*/

Route::get('/manifest.json', fn() => response()->json(config('site.pwa')))
    ->middleware('cache.headers:public;max_age=300;etag')
    ->name('manifest');

/*
|--------------------------------------------------------------------------
| RSS
|--------------------------------------------------------------------------
*/

Route::feeds();
