<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Back\AdminController;
use App\Http\Controllers\Front\PostController;
use \UniSharp\LaravelFilemanager\Lfm;

/*
|--------------------------------------------------------------------------
| Front Web Routes
|--------------------------------------------------------------------------
|
*/
Route::group(["prefix" => "laravel-filemanager", "middleware" => "auth"], function (){
    Lfm::routes();
});

Route::name("home")->get('/', [PostController::class, "index"]);

Route::prefix("posts")->group(function(){
    Route::name("post.display")->get("{slug}", [PostController::class, "show"]);
});

Route::get('/logout')->name("logout");


/*
|--------------------------------------------------------------------------
| Back Web Routes
|--------------------------------------------------------------------------
|
*/

Route::prefix("admin")->group(function(){
    Route::middleware("redac")->group(function() {
        Route::name("admin")->get('/', [AdminController::class, "index"]);
    });
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



require __DIR__.'/auth.php';
