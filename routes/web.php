<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Con;
use App\Http\Controllers\Controller_auth;
use App\Http\Controllers\Controller_dashboard;
use App\Http\Controllers\Controller_dosen;
use App\Http\Controllers\Controller_jurusan;
use App\Http\Controllers\Controller_ruangan;

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

Route::redirect('/', '/login');
// routes auth
Route::get('/login', [Controller_auth::class, 'show'])->name('login');
Route::post('/login', [Controller_auth::class, 'login'])->name('auth');
Route::post('/logout', [Controller_auth::class, 'logout'])->name('logout');
Route::get('/dashboard', [Controller_dashboard::class, 'show'])->name('dashboard');

// routes dosen
Route::get('/dosen', [Controller_dosen::class, 'show'])->name('dosen');
Route::delete('/dosen-delete/{id}', [Controller_dosen::class, 'delete'])->name('hapus_dosen');
Route::get('/dosen/{id}/edit', [Controller_dosen::class, 'edit'])->name('edit_dosen');
Route::put('/dosen/{id}', [Controller_dosen::class, 'update'])->name('update_dosen');
Route::get('/dosen/tambah', [Controller_dosen::class, 'tambah'])->name('store_dosen');
Route::post('/dosen/tambah', [Controller_dosen::class, 'create'])->name('store_dosen');
// routes dosen
Route::get('/jurusan', [Controller_jurusan::class, 'show'])->name('jurusan');
Route::delete('/jurusan-delete/{id}', [Controller_jurusan::class, 'delete'])->name('hapus_jurusan');
Route::get('/jurusan/{id}/edit', [Controller_jurusan::class, 'edit'])->name('edit_jurusan');
Route::put('/jurusan/{id}', [Controller_jurusan::class, 'update'])->name('update_jurusan');
Route::get('/jurusan/tambah', [Controller_jurusan::class, 'tambah'])->name('store_jurusan');
