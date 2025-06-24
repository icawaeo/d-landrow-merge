<?php

namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use Illuminate\Http\Request;
use App\Models\Sosialisasi;
use Illuminate\Support\Facades\Storage;

class SosialisasiController extends Controller
{
    // Menampilkan halaman utama Sosialisasi dengan tabel data
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $sosialisasis = $pengadaanTanah->sosialisasis()->latest()->get();

        return view('pengadaan_tanah.sosialisasi.index', [
            'proyek' => $pengadaanTanah,
            'sosialisasis' => $sosialisasis,
        ]);
    }

    // Menampilkan form untuk menambah data sosialisasi baru
    public function create(PengadaanTanah $pengadaanTanah)
    {
        return view('pengadaan_tanah.sosialisasi.create', [
            'proyek' => $pengadaanTanah,
        ]);
    }

    // Menyimpan data baru ke database
    public function store(Request $request, PengadaanTanah $pengadaanTanah)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120', // max 5MB
        ]);

        $path = null;
        if ($request->hasFile('lampiran_berita_acara')) {
            $path = $request->file('lampiran_berita_acara')->store('sosialisasi_files', 'public');
        }

        $pengadaanTanah->sosialisasis()->create([
            'nama_kecamatan' => $request->nama_kecamatan,
            'status' => $request->status,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'lampiran_berita_acara' => $path,
        ]);

        return redirect()->route('sosialisasi.index', $pengadaanTanah->id)->with('success', 'Data sosialisasi berhasil ditambahkan!');
    }
     public function edit(Sosialisasi $sosialisasi)
    {
        return view('pengadaan_tanah.sosialisasi.edit', [
            'sosialisasi' => $sosialisasi,
            'proyek' => $sosialisasi->pengadaanTanah, // Ambil data proyek dari relasi
        ]);
    }

    public function update(Request $request, Sosialisasi $sosialisasi)
    {
        $validatedData = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            // Hapus file lama jika ada
            if ($sosialisasi->lampiran_berita_acara) {
                Storage::disk('public')->delete($sosialisasi->lampiran_berita_acara);
            }
            // Simpan file baru
            $validatedData['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('sosialisasi_files', 'public');
        }

        $sosialisasi->update($validatedData);

        return redirect()->route('sosialisasi.index', $sosialisasi->pengadaan_tanah_id)->with('success', 'Data sosialisasi berhasil diperbarui!');
    }

    public function destroy(Sosialisasi $sosialisasi)
    {
        // Hapus file dari storage jika ada
        if ($sosialisasi->lampiran_berita_acara) {
            Storage::disk('public')->delete($sosialisasi->lampiran_berita_acara);
        }
        
        $pengadaanTanahId = $sosialisasi->pengadaan_tanah_id;
        $sosialisasi->delete();

        return redirect()->route('sosialisasi.index', $pengadaanTanahId)->with('success', 'Data sosialisasi berhasil dihapus!');
    }
}