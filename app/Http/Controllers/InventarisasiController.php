<?php

namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Inventarisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarisasiController extends Controller
{
    // Menampilkan halaman utama Inventarisasi dengan tabel data
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $inventarisasis = $pengadaanTanah->inventarisasis()->latest()->get();

        return view('pengadaan_tanah.inventarisasi.index', [
            'proyek' => $pengadaanTanah,
            'inventarisasis' => $inventarisasis,
        ]);
    }

    // Menampilkan form untuk menambah data inventarisasi baru
    public function create(PengadaanTanah $pengadaanTanah)
    {
        return view('pengadaan_tanah.inventarisasi.create', [
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
            $path = $request->file('lampiran_berita_acara')->store('inventarisasi_files', 'public');
        }

        $pengadaanTanah->inventarisasis()->create([
            'nama_kecamatan' => $request->nama_kecamatan,
            'status' => $request->status,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'lampiran_berita_acara' => $path,
        ]);

        return redirect()->route('inventarisasi.index', $pengadaanTanah->id)->with('success', 'Data inventarisasi berhasil ditambahkan!');
    }

    // Menampilkan form edit
    public function edit(Inventarisasi $inventarisasi)
    {
        return view('pengadaan_tanah.inventarisasi.edit', [
            'inventarisasi' => $inventarisasi,
            'proyek' => $inventarisasi->pengadaanTanah,
        ]);
    }

    // Update data inventarisasi
    public function update(Request $request, Inventarisasi $inventarisasi)
    {
        $validatedData = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($inventarisasi->lampiran_berita_acara) {
                Storage::disk('public')->delete($inventarisasi->lampiran_berita_acara);
            }
            $validatedData['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('inventarisasi_files', 'public');
        }

        $inventarisasi->update($validatedData);

        return redirect()->route('inventarisasi.index', $inventarisasi->pengadaan_tanah_id)->with('success', 'Data inventarisasi berhasil diperbarui!');
    }

    // Hapus data inventarisasi
    public function destroy(Inventarisasi $inventarisasi)
    {
        if ($inventarisasi->lampiran_berita_acara) {
            Storage::disk('public')->delete($inventarisasi->lampiran_berita_acara);
        }

        $pengadaanTanahId = $inventarisasi->pengadaan_tanah_id;
        $inventarisasi->delete();

        return redirect()->route('inventarisasi.index', $pengadaanTanahId)->with('success', 'Data inventarisasi berhasil dihapus!');
    }
}
