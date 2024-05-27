<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\CategoriaNoticiaController;
use App\Http\Controllers\Api\EstadoNoticiaController;
use App\Http\Controllers\Api\NoticiaController;
use App\Http\Controllers\Api\SocioController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\DirectivoController;
use App\Http\Controllers\Api\CategoriaEnlaceController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\LinkController;
use App\Http\Controllers\Api\UsersController;
use App\Models\User;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/users', UsersController::class);

    Route::controller(UsersController::class)->group(function () {
        Route::prefix('verify')->group(function () {
            Route::post('/user', 'verifyUser');
            Route::post('/email', 'verifyEmail');
            Route::post('/userById/{user}', 'verifyUserById');
            Route::post('/emailById/{user}', 'verifyEmailById');
        });
    });

    Route::resource('/faqs', FaqController::class);
    Route::resource('/categoryNew', CategoriaNoticiaController::class);
    Route::resource('/estadoNew', EstadoNoticiaController::class);
    Route::resource('/noticias', NoticiaController::class);
    Route::resource('/socios', SocioController::class);
    Route::resource('/servicios', ServiceController::class);
    Route::resource('/directivos', DirectivoController::class);
    Route::resource('/categorylink', CategoriaEnlaceController::class);
    Route::resource('/enlaces', CategoriaEnlaceController::class);
    Route::resource('/enlaces', LinkController::class);
    Route::resource('/comentarios', CommentController::class);

    Route::get('/empresa', [EmpresaController::class, 'index']);
    Route::post('/storeEmpresa', [EmpresaController::class, 'storeEmpresa']);
    Route::put('/updateEmpresa/{empresa}', [EmpresaController::class, 'updateEmpresa']);
    Route::patch('/storeInfoEmpresa/{empresa}', [EmpresaController::class, 'storeInfoEmpresa']);
    Route::patch('/updateInfoEmpresa/{empresa}', [EmpresaController::class, 'UpdateInfoEmpresa']);
    Route::put('/upload/{empresa}', [EmpresaController::class, 'uploadVideo']);
    Route::delete('/deleteVideo/{empresa}', [EmpresaController::class, 'deleteVideo']);
    Route::get('/video/{empresa}', [EmpresaController::class, 'showVideo']);
});
