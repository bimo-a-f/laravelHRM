<?php

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\GolonganController;
use App\Http\Controllers\API\BukuTamuController;
use App\Http\Controllers\MenuAksesController;
use App\Http\Controllers\MenuMainController;
use App\Models\MenuMain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResources([
    'user' => UserController::class,
]);
Route::apiResources([
    'akses-menu' => MenuAksesController::class,
]);
Route::apiResources([
    'main-menu' => MenuMainController::class,
]);

Route::apiResources([
    'main-menu' => MenuMainController::class,
]);
Route::apiResources([
    'golongan' => GolonganController::class,
]);
Route::apiResources([
    'buku-tamu' => BukuTamuController::class,
]);

//multi Delete
Route::post('main-menu/{data}', [MenuMainController::class, 'deletebanyak']);
Route::post('user/{user}', [UserController::class, 'deletebanyak']);
Route::post('golonganMultiDelete', [GolonganController::class, 'deletebanyak']);
Route::post('bukuTamuMultiDelete', [BukuTamuController::class, 'deletebanyak']);
Route::put('tamu-selesai/{id}', [BukuTamuController::class, 'tamuSelesai']);

Route::get('multiselect', [UserController::class, 'getDatas']);
Route::get('multiakses', [MenuAksesController::class, 'getDatas']);
Route::get('multimainmenu', [MenuMainController::class, 'getDatas']);
//Route::get('akses-menu', [AksesController::class, 'getDatas']);

Route::get('cek', [MenuAksesController::class, 'cek']);
