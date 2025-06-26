<?php
namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Musyawarah;
use Illuminate\Http\Request;

class MusyawarahController extends Controller
{
    // Menampilkan halaman utama Musyawarah dengan datanya
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $musyawarahItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();
        return view('pengadaan_tanah.musyawarah.index', [ 
            'proyek' => $pengadaanTanah,
            'musyawarahItems' => $musyawarahItems
        ]);
    }

    // Menyimpan data baru dari form inline
    public function store(Request $request, PengadaanTanah $pengadaanTanah)
    {
        $request->validate([
            'no_tip' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'nilai' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $pengadaanTanah->musyawarahs()->create($request->all());

        return back()->with('success', 'Data Musyawarah berhasil ditambahkan.');
    }

    // Mengupload bukti dokumen untuk item yang sudah ada
    public function upload(Request $request, Musyawarah $musyawarah)
    {
        $request->validate([
            'bukti_dokumen' => 'required|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        // Hapus file lama jika ada
        if ($musyawarah->bukti_dokumen && \Storage::disk('public')->exists($musyawarah->bukti_dokumen)) {
            \Storage::disk('public')->delete($musyawarah->bukti_dokumen);
        }

        $path = $request->file('bukti_dokumen')->store('bukti_musyawarah', 'public');

        $musyawarah->update(['bukti_dokumen' => $path]);

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }
}