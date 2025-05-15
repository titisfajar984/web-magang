<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Perusahaan\InternshipPostingsController;
use App\Http\Controllers\Perusahaan\ProfileController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/index', 'admin.index')->name('index');
    Route::resource('users', UserController::class);
    Route::resource('company', CompanyController::class);
});

Route::middleware(['auth', 'role:perusahaan'])->prefix('perusahaan')->name('perusahaan.')->group(function () {
    Route::view('/index', 'perusahaan.index')->name('index');
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('internships', InternshipPostingsController::class);
});

Route::middleware(['auth', 'role:peserta'])->prefix('peserta')->name('peserta.')->group(function () {
    Route::view('/index', 'peserta.index')->name('index');
});
