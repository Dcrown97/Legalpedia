<?php

use App\Http\Controllers\ApiLoginController;
use App\Http\Controllers\ApiRegisterController;
use App\Http\Controllers\EmployeeController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/', [LoginController::class, 'index'])->name('login');

// Route::match(["GET", "POST"], '/', [ApiLoginController::class, "index"]);
// Route::match(["GET", "POST"], '/login', [ApiLoginController::class, "login"]);
// Route::match(["GET", "POST"], '/register', [ApiRegisterController::class, "register"]);

Route::post('/register', [ApiRegisterController::class, "register"]);
Route::post('/login', [ApiLoginController::class, "login"]);

Route::apiResource('/employee', EmployeeController::class)->middleware('api');
