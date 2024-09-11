<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller_auth;
use App\Http\Controllers\Controller_dashboard;
use App\Http\Controllers\Controller_dosen;
use App\Http\Controllers\Controller_Export;
use App\Http\Controllers\Controller_jadwal_kuliah;
use App\Http\Controllers\Controller_jurusan;
use App\Http\Controllers\Controller_kelas;
use App\Http\Controllers\Controller_ketersediaan_dosen;
use App\Http\Controllers\Controller_kurikulum;
use App\Http\Controllers\Controller_Mahasiswa;
use App\Http\Controllers\Controller_mata_kuliah;
use App\Http\Controllers\Controller_Perhitungan;
use App\Http\Controllers\Controller_populations;
use App\Http\Controllers\Controller_ruangan;
use App\Http\Controllers\Controller_users;

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
Route::post('/dosen/import', [Controller_dosen::class, 'import'])->name('import-dosens');
// routes jurusan
Route::get('/jurusan', [Controller_jurusan::class, 'show'])->name('jurusan');
Route::delete('/jurusan-delete/{id}', [Controller_jurusan::class, 'delete'])->name('hapus_jurusan');
Route::get('/jurusan/{id}/edit', [Controller_jurusan::class, 'edit'])->name('edit_jurusan');
Route::put('/jurusan/{id}', [Controller_jurusan::class, 'update'])->name('update_jurusan');
Route::post('/jurusan/tambah', [Controller_jurusan::class, 'create'])->name('store_jurusan');
Route::post('/jurusan/import', [Controller_jurusan::class, 'import'])->name('import-jurusans');
// routes matkul
Route::get('/matkul', [Controller_mata_kuliah::class, 'show'])->name('matkul');
Route::delete('/matkul-delete/{id}', [Controller_mata_kuliah::class, 'delete'])->name('hapus_matkul');
Route::get('/matkul/{id}/edit', [Controller_mata_kuliah::class, 'edit'])->name('edit_matkul');
Route::put('/matkul/{id}', [Controller_mata_kuliah::class, 'update'])->name('update_matkul');
Route::post('/matkul/tambah', [Controller_mata_kuliah::class, 'create'])->name('store_matkul');
Route::post('/matkul/import', [Controller_mata_kuliah::class, 'import'])->name('import-matkuls');
// routes ruangan
Route::get('/ruangan', [Controller_ruangan::class, 'show'])->name('ruangan');
Route::delete('/ruangan-delete/{id}', [Controller_ruangan::class, 'delete'])->name('hapus_ruangan');
Route::get('/ruangan/{id}/edit', [Controller_ruangan::class, 'edit'])->name('edit_ruangan');
Route::put('/ruangan/{id}', [Controller_ruangan::class, 'update'])->name('update_ruangan');
Route::post('/ruangan/tambah', [Controller_ruangan::class, 'create'])->name('store_ruangan');
Route::post('/ruangan/import', [Controller_ruangan::class, 'import'])->name('import-ruangans');
// routes ketersediaan dosen
Route::get('/ketersediaan-dosen', [Controller_ketersediaan_dosen::class, 'show'])->name('k_dosen');
Route::delete('/ketersediaan-dosen-delete/{id}', [Controller_ketersediaan_dosen::class, 'delete'])->name('hapus_k_dosen');
Route::get('/ketersediaan-dosen/{id}/edit', [Controller_ketersediaan_dosen::class, 'edit'])->name('edit_k_dosen');
Route::put('/ketersediaan-dosen/{id}', [Controller_ketersediaan_dosen::class, 'update'])->name('update_k_dosen');
Route::post('/ketersediaan-dosen/tambah', [Controller_ketersediaan_dosen::class, 'create'])->name('store_k_dosen');
// routes users
Route::get('/user', [Controller_users::class, 'show'])->name('user');
Route::delete('/user-delete/{id}', [Controller_users::class, 'delete'])->name('hapus_user');
Route::get('/user/{id}/edit', [Controller_users::class, 'edit'])->name('edit_user');
Route::put('/user/{id}', [Controller_users::class, 'update'])->name('update_user');
Route::post('/user/tambah', [Controller_users::class, 'create'])->name('store_user');
// routes kelas
Route::get('/kelas', [Controller_kelas::class, 'show'])->name('kelas');
Route::post('/kelas/tambah', [Controller_kelas::class, 'create'])->name('store_kelas');
Route::delete('/kelas-delete/{id}', [Controller_kelas::class, 'delete'])->name('hapus_kelas');
Route::get('/kelas/{id}/edit', [Controller_kelas::class, 'edit'])->name('edit_kelas');
Route::put('/kelas/{id}', [Controller_kelas::class, 'update'])->name('update_kelas');

// routes pengampu
Route::get('/pengampu', [Controller_populations::class, 'pengampu'])->name('pengampu');
// Route::post('/population/tambah', [Controller_populations::class, 'create'])->name('store_population');
// Route::delete('/population-delete/{id}', [Controller_populations::class, 'delete'])->name('hapus_population');
// Route::get('/population/{id}/edit', [Controller_populations::class, 'edit'])->name('edit_population');
// Route::put('/population/{id}', [Controller_populations::class, 'update'])->name('update_population');
// routes populations
Route::get('/population', [Controller_populations::class, 'show'])->name('population');
Route::post('/population/tambah', [Controller_populations::class, 'create'])->name('store_population');
Route::delete('/population-delete/{id}', [Controller_populations::class, 'delete'])->name('hapus_population');
Route::get('/population/{id}/edit', [Controller_populations::class, 'edit'])->name('edit_population');
Route::put('/population/{id}', [Controller_populations::class, 'update'])->name('update_population');
// routes kurikulum
Route::get('/kurikulum', [Controller_kurikulum::class, 'show'])->name('kurikulum');
Route::post('/kurikulum/tambah', [Controller_kurikulum::class, 'create'])->name('store_kurikulum');
Route::delete('/kurikulum-delete/{id}', [Controller_kurikulum::class, 'delete'])->name('hapus_kurikulum');
Route::get('/kurikulum/{id}/edit', [Controller_kurikulum::class, 'edit'])->name('edit_kurikulum');
Route::put('/kurikulum/{id}', [Controller_kurikulum::class, 'update'])->name('update_kurikulum');

// Route::get('/population/periode', [Controller_kurikulum::class, 'select_periode'])->name('kurikum-periode');
// generate data
Route::post('/population-generate', [Controller_populations::class, 'generate'])->name('generate-population');
Route::post('/save-schedules', [Controller_populations::class, 'saveSchedules'])->name('saveSchedules');


Route::post('/generate-jadwal', [Controller_Perhitungan::class, 'generateSchedule'])->name('generate-jadwal');

// mahasiswa 

Route::get('/mahasiswa/', [Controller_Mahasiswa::class, 'show'])->name('dashboard-mahasiswa');
Route::post('/population/export', [Controller_populations::class, 'export'])->name('export-populations');


// Export
Route::get('Export', [Controller_Export::class, 'show'])->name('Export-table');
