<?php

namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\MusyawarahSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusyawarahSubController extends Controller
{
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $musyawarahs = $pengadaanTanah->musyawarah_subs()->latest()->get();
        return view('pengadaan_tanah.musyawarah_sub.index', [
            'proyek' => $pengadaanTanah,
            'musyawarahs' => $musyawarahs
        ]);
    }

    public function create(PengadaanTanah $pengadaanTanah)
    {
        return view('pengadaan_tanah.musyawarah_sub.create', ['proyek' => $pengadaanTanah]);
    }

    public function store(Request $request, PengadaanTanah $pengadaanTanah)
    {
        // Validasi dengan pesan custom
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ], [
            'nama_kecamatan.required' => 'Kolom Lokasi Musyawarah wajib diisi.' // Pesan error disesuaikan
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('musyawarah_files', 'public');
        }

        $pengadaanTanah->musyawarah_subs()->create($data);
        return redirect()->route('musyawarah_sub.index', $pengadaanTanah->id)->with('success', 'Data musyawarah berhasil ditambahkan!');
    }

    public function edit(MusyawarahSub $musyawarahSub)
    {
        return view('pengadaan_tanah.musyawarah_sub.edit', [
            'musyawarah' => $musyawarahSub,
            'proyek' => $musyawarahSub->pengadaanTanah,
        ]);
    }

    public function update(Request $request, MusyawarahSub $musyawarahSub)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ], [
            'nama_kecamatan.required' => 'Kolom Lokasi Musyawarah wajib diisi.'
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($musyawarahSub->lampiran_berita_acara) {
                Storage::disk('public')->delete($musyawarahSub->lampiran_berita_acara);
            }
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('musyawarah_files', 'public');
        }

        $musyawarahSub->update($data);
        return redirect()->route('musyawarah_sub.index', $musyawarahSub->pengadaan_tanah_id)->with('success', 'Data musyawarah berhasil diperbarui!');
    }

    public function destroy(MusyawarahSub $musyawarahSub)
    {
        if ($musyawarahSub->lampiran_berita_acara) {
            Storage::disk('public')->delete($musyawarahSub->lampiran_berita_acara);
        }
        
        $pengadaanTanahId = $musyawarahSub->pengadaan_tanah_id;
        $musyawarahSub->delete();
        return redirect()->route('musyawarah_sub.index', $pengadaanTanahId)->with('success', 'Data musyawarah berhasil dihapus!');
    }
}