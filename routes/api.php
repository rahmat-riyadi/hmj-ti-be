 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\Guest\HomeController;

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
