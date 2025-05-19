<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Company\InternshipPostingsController;
use App\Http\Controllers\Company\InternshipsController;
use App\Http\Controllers\Company\ProfileController;
use App\Http\Controllers\Participant\ParticipantIntershipsController;
use App\Http\Controllers\Participant\ParticipantProfileController;
use Illuminate\Support\Facades\Mail;

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
Route::get('/test-email', function () {
    Mail::raw('Tes kirim email berhasil!', function ($message) {
        $message->to('your@email.com') // Ganti dengan email aktif kamu (atau dummy jika hanya ingin cek Mailtrap)
                ->subject('Tes Email dari Laravel');
    });

    return 'Email berhasil dikirim!';
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/index', 'admin.index')->name('index');
    Route::resource('users', UserController::class);
    Route::resource('company', CompanyController::class);
});

Route::middleware(['auth', 'role:company'])->prefix('company')->name('company.')->group(function () {
    Route::view('/index', 'company.index')->name('index');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::resource('internships', InternshipPostingsController::class);
    Route::get('applications', [InternshipsController::class, 'applications'])->name('apply.index');
    Route::get('applications/{application}', [InternshipsController::class, 'showApplication'])->name('apply.show');
    Route::put('applications/{application}', [InternshipsController::class, 'updateApplication'])->name('apply.update');
});

Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {
    Route::view('/index', 'participant.index')->name('index');
    Route::get('profile', [ParticipantProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [ParticipantProfileController::class, 'update'])->name('profile.update');
    Route::resource('internships', ParticipantIntershipsController::class);
    Route::post('internships/{id}/apply', [ParticipantIntershipsController::class, 'apply'])->name('internships.apply');
    Route::get('apply', [ParticipantIntershipsController::class, 'myApplications'])->name('apply.index');
});
