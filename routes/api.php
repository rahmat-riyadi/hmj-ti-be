<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\Guest\HomeController;
use App\Http\Controllers\Guest\ArticleController;
use App\Http\Controllers\Guest\BusinessController;
use App\Http\Controllers\User\UserMemberController;
use App\Http\Controllers\User\UserArticleController;
use App\Http\Controllers\User\UserBusinessController;
use App\Http\Controllers\User\UserComplaintController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(HomeController::class)->group(function () {
    Route::get('home/carousel', 'carousel');
    Route::get('home/article', 'article');
    Route::get('home/business', 'business');
    Route::post('home/complaint', 'storeComplaint');
});

Route::controller(ArticleController::class)->group(function () {
    Route::get('article', 'index');
    Route::get('article/{article:slug}', 'show');
});

Route::controller(BusinessController::class)->group(function () {
    Route::get('business', 'index');
});

// User
Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('user')->group(function () {
        Route::controller(UserArticleController::class)->group(function () {
            Route::get('article', 'index');
            Route::post('article', 'store');
            Route::get('article/{article:slug}', 'show');
            Route::patch('article/{article:slug}', 'update');
            Route::delete('article/{article:slug}', 'destroy'); 
        });
        Route::controller(UserBusinessController::class)->group(function () {
            Route::post('business', 'store');
            Route::get('business', 'index');
            Route::get('business/{business}', 'show');
            Route::patch('business/{business}', 'update');
            Route::delete('business/{business}', 'destroy');
        });
        Route::get('complaint', [UserComplaintController::class, 'index']);
        Route::controller(UserMemberController::class)->group(function () {
            Route::get('member', 'index');
            Route::post('member', 'store');
            Route::get('member/{member}', 'show');
            Route::patch('member/{member}', 'update');
            Route::delete('member/{member}', 'destroy'); 
        });
    });
});

// Login
Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('logout', 'logout')->middleware(['auth:sanctum']);
});