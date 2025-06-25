<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanTanahController; 
use App\Http\Controllers\RowController;
use App\Models\PengadaanTanah; 
use App\Models\Row;             
use App\Http\Controllers\PerizinanController;
use App\Http\Controllers\RowPerizinanController;
use App\Http\Controllers\SosialisasiController;
use App\Http\Controllers\RowSosialisasiController;
use App\Http\Controllers\InventarisasiController;
use App\Http\Controllers\RowInventarisasiController;


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
    return view('landingpage');
});

Route::get('/homepage', function () {
    $daftarPengadaanTanah = PengadaanTanah::latest()->get();
    $daftarRow = Row::latest()->get();
    return view('homepage', [
        'daftarPengadaanTanah' => $daftarPengadaanTanah,
        'daftarRow' => $daftarRow,
    ]);
})->middleware(['auth', 'verified'])->name('homepage');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*pengadaan tanah*/
    Route::get('/pengadaan-tanah/baru/{kategori}', [PengadaanTanahController::class, 'create'])->name('pengadaan_tanah.create');
    Route::post('/pengadaan-tanah', [PengadaanTanahController::class, 'store'])->name('pengadaan_tanah.store');

    Route::get('/pengadaan-tanah/{pengadaanTanah}/edit', [PengadaanTanahController::class, 'edit'])->name('pengadaan_tanah.edit');
    Route::put('/pengadaan-tanah/{pengadaanTanah}', [PengadaanTanahController::class, 'update'])->name('pengadaan_tanah.update');
    Route::delete('/pengadaan-tanah/{pengadaanTanah}', [PengadaanTanahController::class, 'destroy'])->name('pengadaan_tanah.destroy');

    Route::get('/pengadaan-tanah/{pengadaanTanah}/perizinan', [PerizinanController::class, 'edit'])->name('pengadaan_tanah.perizinan.edit');
    Route::post('/pengadaan-tanah/{pengadaanTanah}/perizinan', [PerizinanController::class, 'store'])->name('pengadaan_tanah.perizinan.store');

    Route::get('/pengadaan-tanah/{pengadaanTanah}/sosialisasi', [SosialisasiController::class, 'index'])->name('sosialisasi.index');
    Route::get('/pengadaan-tanah/{pengadaanTanah}/sosialisasi/create', [SosialisasiController::class, 'create'])->name('sosialisasi.create');
    Route::post('/pengadaan-tanah/{pengadaanTanah}/sosialisasi', [SosialisasiController::class, 'store'])->name('sosialisasi.store');

    Route::get('/sosialisasi/{sosialisasi}/edit', [SosialisasiController::class, 'edit'])->name('sosialisasi.edit');
    Route::put('/sosialisasi/{sosialisasi}', [SosialisasiController::class, 'update'])->name('sosialisasi.update');
    Route::delete('/sosialisasi/{sosialisasi}', [SosialisasiController::class, 'destroy'])->name('sosialisasi.destroy');

    Route::get('/pengadaan-tanah/{pengadaanTanah}/inventarisasi', [InventarisasiController::class, 'index'])->name('inventarisasi.index');
    Route::get('/pengadaan-tanah/{pengadaanTanah}/inventarisasi/create', [InventarisasiController::class, 'create'])->name('inventarisasi.create');
    Route::post('/pengadaan-tanah/{pengadaanTanah}/inventarisasi', [InventarisasiController::class, 'store'])->name('inventarisasi.store');

    Route::get('/inventarisasi/{inventarisasi}/edit', [InventarisasiController::class, 'edit'])->name('inventarisasi.edit');
    Route::put('/inventarisasi/{inventarisasi}', [InventarisasiController::class, 'update'])->name('inventarisasi.update');
    Route::delete('/inventarisasi/{inventarisasi}', [InventarisasiController::class, 'destroy'])->name('inventarisasi.destroy');


    /*row*/
    Route::get('/row/baru', [RowController::class, 'create'])->name('row.create');
    Route::post('/row', [RowController::class, 'store'])->name('row.store');

    Route::get('/row/{row}/edit', [RowController::class, 'edit'])->name('row.edit');
    Route::put('/row/{row}', [RowController::class, 'update'])->name('row.update');
    Route::delete('/row/{row}', [RowController::class, 'destroy'])->name('row.destroy');

    Route::get('/row/{row}/perizinan', [RowPerizinanController::class, 'edit'])->name('row.perizinan.edit');
    Route::post('/row/{row}/perizinan', [RowPerizinanController::class, 'store'])->name('row.perizinan.store');

    Route::get('/row/{row}/sosialisasi', [RowSosialisasiController::class, 'index'])->name('row.sosialisasi.index');
    Route::get('/row/{row}/sosialisasi/create', [RowSosialisasiController::class, 'create'])->name('row.sosialisasi.create');
    Route::post('/row/{row}/sosialisasi', [RowSosialisasiController::class, 'store'])->name('row.sosialisasi.store');

    Route::get('/row/sosialisasi/{sosialisasi}/edit', [RowSosialisasiController::class, 'edit'])->name('row.sosialisasi.edit');
    Route::put('/row/sosialisasi/{sosialisasi}', [RowSosialisasiController::class, 'update'])->name('row.sosialisasi.update');
    Route::delete('/row/sosialisasi/{sosialisasi}', [RowSosialisasiController::class, 'destroy'])->name('row.sosialisasi.destroy');

    Route::get('/row/{row}/sosialisasi', [RowSosialisasiController::class, 'index'])->name('row.sosialisasi.index');
    Route::get('/row/{row}/sosialisasi/create', [RowSosialisasiController::class, 'create'])->name('row.sosialisasi.create');
    Route::post('/row/{row}/sosialisasi', [RowSosialisasiController::class, 'store'])->name('row.sosialisasi.store');
    
    Route::get('/row/sosialisasi/{sosialisasi}/edit', [RowSosialisasiController::class, 'edit'])->name('row.sosialisasi.edit');
    Route::put('/row/sosialisasi/{sosialisasi}', [RowSosialisasiController::class, 'update'])->name('row.sosialisasi.update');
    Route::delete('/row/sosialisasi/{sosialisasi}', [RowSosialisasiController::class, 'destroy'])->name('row.sosialisasi.destroy'); 

    Route::get('/row/{row}/inventarisasi', [RowInventarisasiController::class, 'index'])->name('row-inventarisasi.index');
    Route::get('/row/{row}/inventarisasi/create', [RowInventarisasiController::class, 'create'])->name('row-inventarisasi.create');
    Route::post('/row/{row}/inventarisasi', [RowInventarisasiController::class, 'store'])->name('row-inventarisasi.store');
    
    Route::get('/row-inventarisasi/{rowInventarisasi}/edit', [RowInventarisasiController::class, 'edit'])->name('row-inventarisasi.edit');
    Route::put('/row-inventarisasi/{rowInventarisasi}', [RowInventarisasiController::class, 'update'])->name('row-inventarisasi.update');
    Route::delete('/row-inventarisasi/{rowInventarisasi}', [RowInventarisasiController::class, 'destroy'])->name('row-inventarisasi.destroy');

});

require __DIR__.'/auth.php';