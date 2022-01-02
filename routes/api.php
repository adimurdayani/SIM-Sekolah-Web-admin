<?php

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


Route::get('/guru/{mapel_id}', 'Api\GuruController@index');
Route::get('/guru/idcard/{id_card}', 'Api\GuruController@guru_id');
Route::get('/jadwal/{kelas_id}', 'Api\JadwalController@index');
Route::get('/jadwal/nilai_jadwal/{kelas_id}', 'Api\JadwalController@nilai_jadwal');
Route::get('/mapel', 'Api\MapelController@index');
Route::get('/siswa', 'Api\SiswaController@index');
Route::get('/siswa/{kelas_id}', 'Api\SiswaController@kelas_id');
Route::get('/siswa/kelas/{kelas_id}', 'Api\SiswaController@siswa_kelas_id');
Route::get('/siswa/{no_induk}', 'Api\SiswaController@siswa_id');
Route::get('/kelas', 'Api\KelasController@index');
Route::get('/absen', 'Api\AbsenGuruController@index');
Route::get('/user', 'Api\UserController@index');
Route::post('/user/login', 'Api\UserController@login');
Route::post('/user/register', 'Api\UserController@register');
Route::post('/guru/absen/{id}', 'Api\AbsenGuruController@absen');
Route::get('/nilai/{kelas_id}', 'Api\NilaiController@index');
Route::get('/nilai/ulangan/{mapel_id}', 'Api\NilaiController@ulangan');
