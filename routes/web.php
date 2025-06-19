<?php

use Illuminate\Support\Facades\Route;
Auth::routes(['register' => false]);

Route::get('/', 'FrontEndController@index')->name('index');
Route::get('/fe', 'FrontEndController@index')->name('fe');
Route::get('/daftarInternship', 'FrontEndController@daftarInternship')->name('daftarInternship');
Route::post('/createAkun', 'FrontEndController@createAkun')->name('createAkun');

Route::get('/admin', function () { return redirect('admin/beranda'); });
Route::get('home', function () { return redirect('admin/beranda'); })->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin','middleware' => 'auth'], function () {
    Route::get('/', function () { return redirect('admin/beranda'); });
    Route::get('beranda', 'HomeController@index')->name('index');

    // Helper Route Untuk get value select Form
    // Route::get('getSelectsopir', 'HelperController@getSelectsopir')->name('getSelectsopir');

    // Master route
    Route::group(['prefix' => 'master', 'namespace' => 'Master', 'as' => 'master.','middleware' => ['permission:1']], function () {
        // Master Divisi
        Route::group(['prefix' => 'divisi', 'as' => 'divisi.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterDivisiController@index')->name('index');
            Route::post('detail', 'MasterDivisiController@detail')->name('detail');
            Route::post('store', 'MasterDivisiController@store')->name('store');
            Route::post('scopeData', 'MasterDivisiController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterDivisiController@destroy')->name('destroy');
        });
        // Master Jurusan
        Route::group(['prefix' => 'jurusan', 'as' => 'jurusan.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterJurusanController@index')->name('index');
            Route::post('detail', 'MasterJurusanController@detail')->name('detail');
            Route::post('store', 'MasterJurusanController@store')->name('store');
            Route::post('scopeData', 'MasterJurusanController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterJurusanController@destroy')->name('destroy');
        });
         // Master Status Surat
         Route::group(['prefix' => 'statusSurat', 'as' => 'statusSurat.','middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterStatusSuratController@index')->name('index');
            Route::post('detail', 'MasterStatusSuratController@detail')->name('detail');
            Route::post('store', 'MasterStatusSuratController@store')->name('store');
            Route::post('scopeData', 'MasterStatusSuratController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterStatusSuratController@destroy')->name('destroy');
        });
    });

    // Transaksi Route
    Route::group(['prefix' => 'transaksi', 'namespace' => 'Transaksi', 'as' => 'transaksi.','middleware' => ['permission:1']], function () {
        // Transaksi
        Route::get('/', 'TransaksiController@index')->name('index');
        Route::post('action', 'TransaksiController@store')->name('store');
        Route::post('detail', 'TransaksiController@detail')->name('detail');
        Route::post('scopeData', 'TransaksiController@scopeData')->name('scopeData');
        Route::post('destroy', 'TransaksiController@destroy')->name('destroy');
        Route::post('updateStatus', 'TransaksiController@updateStatus')->name('updateStatus');
        // Report
        Route::get('report', 'ReportController@index')->name('report');
    });

    // Route untuk Anak Internship
     Route::group(['prefix' => 'InternshipMember', 'namespace' => 'InternshipMember', 'as' => 'internshipMember.','middleware' => ['permission:2']], function () {
         // Profile
        Route::group(['prefix' => 'profile', 'as' => 'profile.','middleware' => ['permission:2']], function () {
            Route::get('/', 'ProfileController@index')->name('index');
        });
        // Pengajuan Internship
        Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan.','middleware' => ['permission:2']], function () {
            Route::get('/', 'InternshipController@index')->name('index');
            Route::post('/scopeData', 'InternshipController@scopeData')->name('scopeData');
            Route::post('/store', 'InternshipController@store')->name('store');
            Route::get('/detail', 'InternshipController@detail')->name('detail');
            Route::get('/store', 'InternshipController@store')->name('store');
            Route::get('/destroy', 'InternshipController@destroy')->name('destroy');
        });
        // Absensi
        Route::group(['prefix' => 'absensi', 'as' => 'absensi.','middleware' => ['permission:2']], function () {
            Route::get('/', 'AbsensiController@index')->name('index');
        });
        // Jobdesc
        Route::group(['prefix' => 'jobdesc', 'as' => 'jobdesc.','middleware' => ['permission:2']], function () {
            Route::get('/', 'JobdescController@index')->name('index');
        });
        // Penilaian
        Route::group(['prefix' => 'penilaian', 'as' => 'penilaian.','middleware' => ['permission:2']], function () {
            Route::get('/', 'PenilaianController@index')->name('index');
        });
    });

});
 