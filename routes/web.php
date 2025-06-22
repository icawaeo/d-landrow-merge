<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengadaanTanahController; 
use App\Http\Controllers\RowController;
use App\Models\PengadaanTanah; 
use App\Models\Row;             

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

    Route::get('/pengadaan-tanah/baru/{kategori}', [PengadaanTanahController::class, 'create'])->name('pengadaan_tanah.create');
    Route::post('/pengadaan-tanah', [PengadaanTanahController::class, 'store'])->name('pengadaan_tanah.store');

    Route::get('/pengadaan-tanah/{pengadaanTanah}/edit', [PengadaanTanahController::class, 'edit'])->name('pengadaan_tanah.edit');
    Route::put('/pengadaan-tanah/{pengadaanTanah}', [PengadaanTanahController::class, 'update'])->name('pengadaan_tanah.update');
    Route::delete('/pengadaan-tanah/{pengadaanTanah}', [PengadaanTanahController::class, 'destroy'])->name('pengadaan_tanah.destroy');

    Route::get('/row/baru', [RowController::class, 'create'])->name('row.create');
    Route::post('/row', [RowController::class, 'store'])->name('row.store');

    Route::get('/row/{row}/edit', [RowController::class, 'edit'])->name('row.edit');
    Route::put('/row/{row}', [RowController::class, 'update'])->name('row.update');
    Route::delete('/row/{row}', [RowController::class, 'destroy'])->name('row.destroy');
});

require __DIR__.'/auth.php';