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
        $judul = ucwords(str_replace('-', ' ', $kategori));
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
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'kategori' => 'required|string',
            'jumlah_tower' => 'nullable|integer',
        ]);

        PengadaanTanah::create($request->all());

        return redirect()->route('homepage')->with('success', 'Data pengadaan tanah berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit data yang sudah ada.
     */
    public function edit(PengadaanTanah $pengadaanTanah)
    {
        return view('pengadaan_tanah.edit', [
            'proyek' => $pengadaanTanah,
            'judul' => 'Edit Data: ' . $pengadaanTanah->nama_proyek
        ]);
    }

    /**
     * Memperbarui data yang sudah ada di dalam database.
     */
    public function update(Request $request, PengadaanTanah $pengadaanTanah)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'jumlah_tower' => 'nullable|integer',
        ]);

        $pengadaanTanah->update($request->all());

        return redirect()->route('homepage')->with('success', 'Data berhasil diperbarui!');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(PengadaanTanah $pengadaanTanah)
    {
        $pengadaanTanah->delete();

        return redirect()->route('homepage')->with('success', 'Data berhasil dihapus!');
    }

    /**
     * Mengajukan proyek untuk persetujuan.
     */
    public function submitForApproval(PengadaanTanah $pengadaanTanah)
    {
        $pengadaanTanah->update([
            'status_persetujuan' => 'sudah_diajukan',
            'catatan_penolakan' => null,
        ]);
        return redirect()->route('homepage')->with('success', 'Proyek berhasil diajukan untuk persetujuan.');
    }

    /**
     * Menampilkan detail proyek pengadaan tanah.
     */
    public function show(PengadaanTanah $pengadaanTanah)
    {
        $pengadaanTanah = PengadaanTanah::with([
            'perizinan', 'sosialisasi', 'inventarisasi', 'musyawarah', 'musyawarah_sub', 'pembayaran_sub', 'dokumen_hasil'
        ])->findOrFail($id);

        $isLocked = in_array($pengadaanTanah->status_persetujuan, [
            'menunggu_admin_1', 'menunggu_admin_2', 'menunggu_admin_3', 'disetujui'
        ]); 
        
        $perizinan = Perizinan::where('pengadaan_tanah_id', $id)->first();
        $sosialisasi = Sosialisasi::where('pengadaan_tanah_id', $id)->get();
        $inventarisasi = Inventarisasi::where('pengadaan_tanah_id', $id)->get();
        $musyawarah_sub = MusyawarahSub::where('pengadaan_tanah_id', $id)->get();
        $musyawarahs = Musyawarah::where('pengadaan_tanah_id', $id)->get();
        $pembayaran_sub = PembayaranSub::where('pengadaan_tanah_id', $id)->get();
        $dokumen_hasil = DokumenHasil::where('pengadaan_tanah_id', $id)->first();

        return view('pengadaan_tanah.show', compact(
            'pengadaanTanah', 
            'perizinan',
            'sosialisasi',
            'inventarisasi',
            'musyawarah_sub',
            'musyawarahs',
            'pembayaran_sub',
            'dokumen_hasil',
            'isLocked'
        ));
        
    }
}