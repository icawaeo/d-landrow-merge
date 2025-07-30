<?php
namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Musyawarah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MusyawarahController extends Controller
{
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $musyawarahItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();
        return view('pengadaan_tanah.musyawarah.index', [
            'proyek' => $pengadaanTanah,
            'musyawarahItems' => $musyawarahItems
        ]);
    }

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

    public function edit(Musyawarah $musyawarah)
    {
        $pengadaanTanah = $musyawarah->pengadaanTanah;
        $musyawarahItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();
        return view('pengadaan_tanah.musyawarah.index', [
            'proyek' => $pengadaanTanah,
            'musyawarahItems' => $musyawarahItems,
            'itemToEdit' => $musyawarah
        ]);
    }

    /**
     * PERUBAHAN UTAMA: Method update() sekarang bisa memproses file.
     */
    public function update(Request $request, Musyawarah $musyawarah)
    {
        $data = $request->validate([
            'no_tip'              => 'required|string|max:255',
            'nama_pemilik'        => 'required|string|max:255',
            'desa'                => 'required|string|max:255',
            'nilai'               => 'required|numeric',
            'status'              => 'required|string',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120', // Validasi untuk file
        ]);

        // Logika untuk memproses file jika ada yang diunggah saat edit
        if ($request->hasFile('bukti_dokumen')) {
            // Hapus file lama jika ada
            if ($musyawarah->bukti_musyawarah && Storage::disk('public')->exists($musyawarah->bukti_musyawarah)) {
                Storage::disk('public')->delete($musyawarah->bukti_musyawarah);
            }
            // Simpan file baru dan masukkan path-nya ke dalam array $data
            $data['bukti_musyawarah'] = $request->file('bukti_dokumen')->store('bukti_musyawarah', 'public');
        }
        
        $musyawarah->update($data);
        
        return redirect()->route('musyawarah.index', $musyawarah->pengadaan_tanah_id)
                         ->with('success', 'Data berhasil diperbarui!');
    }

    public function upload(Request $request, Musyawarah $musyawarah)
    {
        $request->validate(['bukti_dokumen' => 'required|file|mimes:pdf,jpg,png,docx|max:5120']);
        if ($musyawarah->bukti_musyawarah && Storage::disk('public')->exists($musyawarah->bukti_musyawarah)) {
            Storage::disk('public')->delete($musyawarah->bukti_musyawarah);
        }
        $path = $request->file('bukti_dokumen')->store('bukti_musyawarah', 'public');
        $musyawarah->update(['bukti_musyawarah' => $path]);
        return back()->with('success', 'Dokumen berhasil diunggah.');
    }
    
    public function destroy(Musyawarah $musyawarah)
    {
        $pengadaanTanahId = $musyawarah->pengadaan_tanah_id;
        if ($musyawarah->bukti_musyawarah && Storage::disk('public')->exists($musyawarah->bukti_musyawarah)) {
            Storage::disk('public')->delete($musyawarah->bukti_musyawarah);
        }
        $musyawarah->delete();
        return redirect()->route('musyawarah.index', $pengadaanTanahId)->with('success', 'Data berhasil dihapus.');
    }
}