<?php

namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use Illuminate\Http\Request;

class PengadaanTanahController extends Controller
{
    /**
     * Menampilkan form untuk membuat data pengadaan tanah baru.
     */
    public function create($kategori)
    {
        // Mengubah slug kategori (contoh: 'pengadaan-tanah') menjadi judul (Contoh: 'Pengadaan Tanah')
        $judul = ucwords(str_replace('-', ' ', $kategori));
        
        // Mengarahkan ke view 'create.blade.php' di dalam folder 'pengadaan_tanah'
        return view('pengadaan_tanah.create', [
            'judul' => $judul,
            'kategori' => $kategori
        ]);
    }

    /**
     * Menyimpan data pengadaan tanah baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jumlah_tower' => 'nullable|integer',
            // Tambahkan validasi lain di sini jika perlu
        ]);

        // Membuat data baru menggunakan Model PengadaanTanah
        PengadaanTanah::create($request->all());

        // Kembali ke halaman utama dengan pesan sukses
        return redirect()->route('homepage')->with('success', 'Data pengadaan tanah berhasil dibuat!');
    }
}