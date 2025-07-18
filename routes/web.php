<?php

use Illuminate\Support\Facades\Route;

Auth::routes(['register' => false]);

Route::get('/', 'FrontEndController@index')->name('index');
Route::get('/fe', 'FrontEndController@index')->name('fe');
Route::get('/daftarInternship', 'FrontEndController@daftarInternship')->name('daftarInternship');
Route::post('/createAkun', 'FrontEndController@createAkun')->name('createAkun');

Route::get('/admin', function () {
    return redirect('admin/beranda');
});
Route::get('home', function () {
    return redirect('admin/beranda');
})->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::get('/', function () {
        return redirect('admin/beranda');
    });
    Route::get('beranda', 'HomeController@index')->name('index');

    // Helper Route Untuk get value select Form
    // Route::get('getSelectsopir', 'HelperController@getSelectsopir')->name('getSelectsopir');

    // Master route
    Route::group(['prefix' => 'master', 'namespace' => 'Master', 'as' => 'master.', 'middleware' => ['permission:1']], function () {
        // Master Divisi
        Route::group(['prefix' => 'divisi', 'as' => 'divisi.', 'middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterDivisiController@index')->name('index');
            Route::post('detail', 'MasterDivisiController@detail')->name('detail');
            Route::post('store', 'MasterDivisiController@store')->name('store');
            Route::post('scopeData', 'MasterDivisiController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterDivisiController@destroy')->name('destroy');
        });
        // Master Jurusan
        Route::group(['prefix' => 'jurusan', 'as' => 'jurusan.', 'middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterJurusanController@index')->name('index');
            Route::post('detail', 'MasterJurusanController@detail')->name('detail');
            Route::post('store', 'MasterJurusanController@store')->name('store');
            Route::post('scopeData', 'MasterJurusanController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterJurusanController@destroy')->name('destroy');
        });
        // Master Status Surat
        Route::group(['prefix' => 'statusSurat', 'as' => 'statusSurat.', 'middleware' => ['permission:1']], function () {
            Route::get('/', 'MasterStatusSuratController@index')->name('index');
            Route::post('detail', 'MasterStatusSuratController@detail')->name('detail');
            Route::post('store', 'MasterStatusSuratController@store')->name('store');
            Route::post('scopeData', 'MasterStatusSuratController@scopeData')->name('scopeData');
            Route::post('destroy', 'MasterStatusSuratController@destroy')->name('destroy');
        });
    });

    // Permintaan Internship
    Route::group(['prefix' => 'permintaan', 'as' => 'permintaan.', 'middleware' => ['permission:1']], function () {
        Route::get('/', 'PermintaanInternshipController@index')->name('index');
        Route::post('/scopeData', 'PermintaanInternshipController@scopeData')->name('scopeData');
        Route::post('/uploadSuratBalasan', 'PermintaanInternshipController@uploadSuratBalasan')->name('uploadSuratBalasan');
        Route::post('/accDivisi', 'PermintaanInternshipController@accDivisi')->name('accDivisi');
        Route::post('/tolak', 'PermintaanInternshipController@tolak')->name('tolak');
        Route::post('/selesai', 'PermintaanInternshipController@selesai')->name('selesai');
        Route::post('/detail', 'PermintaanInternshipController@detail')->name('detail');
        Route::get('/store', 'PermintaanInternshipController@store')->name('store');
        Route::get('/downloadSuratBalasan/{key}', 'PermintaanInternshipController@downloadSuratBalasan')->name('downloadSuratBalasan');
        Route::get('/destroy', 'PermintaanInternshipController@destroy')->name('destroy');
    });

    // List Peserta Internship Internship
    Route::group(['prefix' => 'peserta', 'as' => 'peserta.', 'middleware' => ['permission:1']], function () {
        Route::get('/', 'PesertaInternshipController@index')->name('index');
        Route::post('/scopeData', 'PesertaInternshipController@scopeData')->name('scopeData');
        Route::get('/downloadSertifikat/{key}/{surat_balasan}', 'PesertaInternshipController@downloadSertifikat')->name('downloadSertifikat');
        Route::post('/detail', 'PesertaInternshipController@detail')->name('detail');
    });

    // Penilaian & Sertifikat
    Route::group(['prefix' => 'sertifikat', 'as' => 'sertifikat.', 'middleware' => ['permission:1']], function () {
        Route::get('/', 'PenilaianSertifikatController@index')->name('index');
        Route::post('/scopeData', 'PenilaianSertifikatController@scopeData')->name('scopeData');
        Route::post('/detail', 'PenilaianSertifikatController@detail')->name('detail');
        Route::post('/store', 'PenilaianSertifikatController@store')->name('store');
        Route::get('/downloadSertifikat/{key}', 'PenilaianSertifikatController@downloadSertifikat')->name('downloadSertifikat');
        Route::post('/destroy', 'PenilaianSertifikatController@destroy')->name('destroy');
    });

    // Jobdesc
    Route::group(['prefix' => 'jobdesc', 'as' => 'jobdesc.', 'middleware' => ['permission:1']], function () {
        Route::get('/', 'JobDescController@index')->name('index');
        Route::post('/scopeData', 'JobDescController@scopeData')->name('scopeData');
        Route::post('/detail', 'JobDescController@detail')->name('detail');
        Route::post('/store', 'JobDescController@store')->name('store');
        Route::post('/destroy', 'JobDescController@destroy')->name('destroy');
        Route::post('/cancel', 'JobDescController@cancel')->name('cancel');
        Route::post('/verifikasi', 'JobDescController@verifikasi')->name('verifikasi');
    });

    // Absensi / Kehadiran
    Route::group(['prefix' => 'absensi', 'as' => 'absensi.', 'middleware' => ['permission:1']], function () {
        Route::get('/', 'AbsensiController@index')->name('index');
        Route::post('/scopeData', 'AbsensiController@scopeData')->name('scopeData');
        Route::post('/detail', 'AbsensiController@detail')->name('detail');
    });

    // Route untuk Anak Internship ===========================================================================================================================================================================================
    Route::group(['prefix' => 'InternshipMember', 'namespace' => 'InternshipMember', 'as' => 'internshipMember.', 'middleware' => ['permission:2']], function () {
        // Profile
        Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => ['permission:2']], function () {
            Route::get('/', 'ProfileController@index')->name('index');
            Route::post('/updateProfile', 'ProfileController@updateProfile')->name('updateProfile');
        });
        // Pengajuan Internship
        Route::group(['prefix' => 'pengajuan', 'as' => 'pengajuan.', 'middleware' => ['permission:2']], function () {
            Route::get('/', 'InternshipController@index')->name('index');
            Route::post('/scopeData', 'InternshipController@scopeData')->name('scopeData');
            Route::post('/getInternshipUser', 'InternshipController@getInternshipUser')->name('getInternshipUser');
            Route::post('/store', 'InternshipController@store')->name('store');
            Route::post('/uploadMou', 'InternshipController@uploadMou')->name('uploadMou');
            Route::post('/detail', 'InternshipController@detail')->name('detail');
            Route::get('/store', 'InternshipController@store')->name('store');
            Route::get('/downloadSuratBalasan/{key}', 'InternshipController@downloadSuratBalasan')->name('downloadSuratBalasan');
            Route::get('/destroy', 'InternshipController@destroy')->name('destroy');
        });
        // Absensi
        Route::group(['prefix' => 'absensi', 'as' => 'absensi.', 'middleware' => ['permission:2']], function () {
            Route::get('/', 'AbsensiController@index')->name('index');
            Route::post('/scopeData', 'AbsensiController@scopeData')->name('scopeData');
            Route::post('/absensi', 'AbsensiController@absensi')->name('absensi');
        });
        // Jobdesc
        Route::group(['prefix' => 'jobdesc', 'as' => 'jobdesc.', 'middleware' => ['permission:2']], function () {
            Route::get('/', 'JobdescController@index')->name('index');
            Route::post('/scopeData', 'JobdescController@scopeData')->name('scopeData');
            Route::post('/update', 'JobdescController@update')->name('update');
            Route::post('/detail', 'JobdescController@detail')->name('detail');
            Route::post('/destroy', 'JobdescController@destroy')->name('destroy');
            Route::post('/kerjakan', 'JobdescController@kerjakan')->name('kerjakan');
            Route::post('/selesaikan', 'JobdescController@selesaikan')->name('selesaikan');
            Route::post('/pending', 'JobdescController@pending')->name('pending');
            Route::post('/cancel', 'JobdescController@cancel')->name('cancel');
        });
        // Penilaian
        Route::group(['prefix' => 'penilaian', 'as' => 'penilaian.', 'middleware' => ['permission:2']], function () {
            Route::get('/', 'PenilaianController@index')->name('index');
            Route::post('/scopeData', 'PenilaianController@scopeData')->name('scopeData');
            Route::post('/detail', 'PenilaianController@detail')->name('detail');
            Route::get('/downloadSertifikat/{key}', 'PenilaianController@downloadSertifikat')->name('downloadSertifikat');
        });
    });
});
