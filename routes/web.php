<?php

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\EditMemberController;
use App\Http\Controllers\MemberListController;
use App\Http\Controllers\PemasukanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\UangKasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('data-member', function () {
		return view('user-manager/data-member');
	})->name('data-member');

	Route::get('uang-kas', function () {
		return view('uang-kas');
	})->name('uang-kas');
	Route::get('admin-profile', function () {
		return view('admin-profile');
	})->name('admin-profile');

	Route::get('/data-member', 'App\Http\Controllers\MemberListController@list')->name('data-member');
	Route::get('/data-member', [MemberListController::class, 'index'])->name('members.index');
	Route::post('/members', 'App\Http\Controllers\InsertMemberController@store')->name('members.store');
	Route::put('/members/{id}', [EditMemberController::class, 'update'])->name('members.update');
	Route::delete('/members/{id}', [EditMemberController::class, 'delete'])->name('members.delete');

	Route::get('/uang-kas', 'App\Http\Controllers\UangKasController@list')->name('uang-kas.list');
	Route::get('/uang-kas', 'App\Http\Controllers\UangKasController@index')->name('uang-kas.index');
	Route::post('/uang-kas', 'App\Http\Controllers\UangKasController@store')->name('uang-kas.store');
	Route::delete('/uang-kas/{id}', 'App\Http\Controllers\UangKasController@delete')->name('uang-kas.delete');
	Route::post('/export-to-excel', [UangKasController::class, 'exportToExcel'])->name('export-to-excel');

	Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

	Route::resource('pemasukan', PemasukanController::class);
	Route::resource('pengeluaran', PengeluaranController::class);




    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/admin-profile', [InfoUserController::class, 'create'])->name('admin-profile.create');
    Route::post('/admin-profile', [InfoUserController::class, 'store'])->name('admin-profile.store');
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');