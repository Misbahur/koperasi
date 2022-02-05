<?php

use App\Notification;
use Illuminate\Support\Facades\{Auth, Route};

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

  Route::get('simpanan/report', 'SimpananController@report');
  Route::get('simpanan/{id}/struk', 'SimpananController@struk');
  Route::get('pinjaman/report', 'PinjamanController@report');
  Route::get('pinjaman/{id}/struk', 'PinjamanController@struk');
  Route::get('penarikan/report', 'PenarikanController@report');
  Route::get('penarikan/{id}/struk', 'PenarikanController@struk');

  Route::get('/home', 'HomeController@index')->name('home');
  Route::resource('simpanan', 'SimpananController');
  Route::resource('nasabah', 'NasabahController');
  Route::resource('penarikan', 'PenarikanController');
  Route::resource('pinjaman', 'PinjamanController');
  Route::resource('bayar', 'BayarController');
  Route::get('laporan/simpanan', 'LaporanController@simpanan');
  Route::get('laporan/penarikan', 'LaporanController@penarikan');
  Route::get('laporan/pinjaman', 'LaporanController@pinjaman');
  Route::resource('laporan', 'LaporanController');
});

Route::group(['prefix' => 'admin'], function () {
  Route::resource('/users', 'Admin\UserController');
  Route::resource('/roles', 'Admin\RoleController');
  Route::resource('/permissions', 'Admin\PermissionController');

  Route::middleware(['role:admin'])->group(function () {
    Route::get('notifications', 'NotificationController@index')->name('notif');
    Route::get('notification/{slug}', 'NotificationController@show')->name('detail.notif');
  });
});

Route::middleware(['auth', 'role:nasabah'])->group(function () {
  Route::get('deposits', 'User\SimpananController@index')->name('simpanan.nasabah');
  Route::post('deposits', 'User\SimpananController@store')->name('simpanan.save');
  Route::get('deposit/{id}/edit', 'User\SimpananController@edit')->name('simpanan.edit');
  Route::patch('deposit/{id}', 'User\SimpananController@update')->name('simpanan.update');
  Route::delete('deposit/{id}', 'User\SimpananController@destroy')->name('simpanan.destroy');

  Route::get('loans', 'User\PinjamanController@index')->name('pinjaman.nasabah');
  Route::post('loans', 'User\PinjamanController@store')->name('pinjaman.save');
  Route::get('loan/{id}', 'User\PinjamanController@edit')->name('pinjaman.edit');
  Route::patch('loan/{id}', 'User\PinjamanController@update')->name('pinjaman.update');
  Route::delete('loan/{id}', 'User\PinjamanController@destroy')->name('pinjaman.destroy');
  Route::get('loan/{id}/installment', 'User\PinjamanController@installment')->name('angsuran');

  Route::get('withdraw', 'User\PenarikanController@index')->name('penarikan.nasabah');
  Route::post('withdraw', 'User\PenarikanController@store')->name('penarikan.save');
  Route::get('withdraw/{id}', 'User\PenarikanController@edit')->name('penarikan.edit');
  Route::patch('withdraw/{id}', 'User\PenarikanController@update')->name('penarikan.update');
  Route::delete('withdraw/{id}', 'User\PenarikanController@destroy')->name('penarikan.destroy');

  Route::get('notifikasi', 'User\NotifikasiController@index')->name('notif.nasabah');
  Route::get('notifikasi/{slug}', 'User\NotifikasiController@detail')->name('detail.notif.nasabah');
});
