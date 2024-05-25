<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Con;
use App\Http\Controllers\Controller_auth;
use App\Http\Controllers\Controller_dashboard;
use App\Http\Controllers\Controller_dosen;
use App\Http\Controllers\Controller_jurusan;
use App\Http\Controllers\Controller_mata_kuliah;
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
Route::post('/dosen/tambah', [Controller_dosen::class, 'create'])->name('store_dosen');
// routes jurusan
Route::get('/jurusan', [Controller_jurusan::class, 'show'])->name('jurusan');
Route::delete('/jurusan-delete/{id}', [Controller_jurusan::class, 'delete'])->name('hapus_jurusan');
Route::get('/jurusan/{id}/edit', [Controller_jurusan::class, 'edit'])->name('edit_jurusan');
Route::put('/jurusan/{id}', [Controller_jurusan::class, 'update'])->name('update_jurusan');
Route::post('/jurusan/tambah', [Controller_jurusan::class, 'create'])->name('store_jurusan');
// routes matkul
Route::get('/matkul', [Controller_mata_kuliah::class, 'show'])->name('matkul');
Route::delete('/matkul-delete/{id}', [Controller_mata_kuliah::class, 'delete'])->name('hapus_matkul');
Route::get('/matkul/{id}/edit', [Controller_mata_kuliah::class, 'edit'])->name('edit_matkul');
Route::put('/matkul/{id}', [Controller_mata_kuliah::class, 'update'])->name('update_matkul');
Route::post('/matkul/tambah', [Controller_mata_kuliah::class, 'create'])->name('store_matkul');
// routes ruangan
Route::get('/ruangan', [Controller_ruangan::class, 'show'])->name('ruangan');
Route::delete('/ruangan-delete/{id}', [Controller_ruangan::class, 'delete'])->name('hapus_ruangan');
Route::get('/ruangan/{id}/edit', [Controller_ruangan::class, 'edit'])->name('edit_ruangan');
Route::put('/ruangan/{id}', [Controller_ruangan::class, 'update'])->name('update_ruangan');
Route::post('/ruangan/tambah', [Controller_ruangan::class, 'create'])->name('store_ruangan');
