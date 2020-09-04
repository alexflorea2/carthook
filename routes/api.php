<?php

use ApiV1\ErrorResponse;
use Illuminate\Support\Facades\Route;
use \ApiV1\Controllers\UsersController;
use \ApiV1\Controllers\PostsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function() {

    // Users
    Route::prefix('users')->group(function() {
        Route::get('/', [UsersController::class,'index'])->name('api.v1.users');
        Route::get('/{id}', [UsersController::class,'show'])->name('api.v1.users.show');
        Route::get('/{id}/posts', [UsersController::class,'posts'])->name('api.v1.users.posts');
    });

    // Posts
    Route::prefix('posts')->group(function() {
        Route::get('/', [PostsController::class,'index'])->name('api.v1.posts.index');
        Route::get('/{id}/comments', [PostsController::class,'comments'])->name('api.v1.posts.comments');
    });

    Route::any('{catchall}', function(\Illuminate\Http\Request $request){
        return ErrorResponse::output(
            $request->getUri(),
            '404',
            'Nothing here :)'
        );
    })->where('catchall', '.*');

});
