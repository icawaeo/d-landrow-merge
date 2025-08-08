<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenHasil;
use App\Models\PengadaanTanah;
use Illuminate\Support\Facades\Storage;

class DokumenHasilController extends Controller
{
    /**
     * Menampilkan daftar dokumen hasil untuk proyek tertentu.
     */
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $dokumen = $pengadaanTanah->dokumenHasils()->latest()->get();

        return view('pengadaan_tanah.dokumenhasil', [
            'proyek' => $pengadaanTanah,
            'dokumen' => $dokumen, 
        ]);
    }

    /**
     * Mengupload file untuk dokumen yang sudah ada.
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $dokumen = DokumenHasil::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $path = $request->file('file')->store('dokumenhasil', 'public');
            $dokumen->file_path = $path;
            $dokumen->save();
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    /**
     * Menyimpan data dokumen hasil baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|max:255',
            'total_tip_luas' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
            'pengadaan_tanah_id' => 'required|exists:pengadaan_tanahs,id',
        ]);

        DokumenHasil::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }
}