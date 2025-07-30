<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use App\Models\PengadaanTanah; 
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    /**
     * Menampilkan halaman Sertifikat awal.
     */
    public function index(PengadaanTanah $proyek)
    {
        return view('pengadaan_tanah.sertifikat.index', [
            'proyek' => $proyek
        ]);
    }

    /**
     * Mencari data sertifikat dan menampilkannya di peta.
     */
    public function search(Request $request, PengadaanTanah $proyek)
    {
        $request->validate([
            'no_tip' => 'required',
            'x' => 'required|numeric',
            'y' => 'required|numeric',
        ]);

        $result = Sertifikat::where('no_tip', $request->no_tip)
            ->where('x', $request->x)
            ->where('y', $request->y)
            ->first();

        return view('pengadaan_tanah.sertifikat.index', [
            'proyek' => $proyek,
            'result' => $result,
            'searchInput' => $request->all() 
        ]);
    }

    /**
     * Mengupload file sertifikat.
     */
    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,png|max:2048',
        ]);

        $sertifikat = Sertifikat::findOrFail($id);

        if ($request->hasFile('file')) {
            if ($sertifikat->file_path && Storage::disk('public')->exists($sertifikat->file_path)) {
                Storage::disk('public')->delete($sertifikat->file_path);
            }
            $path = $request->file('file')->store('sertifikat', 'public');
            $sertifikat->file_path = $path;
            $sertifikat->save();
        }

        return redirect()->back()->with('success', 'Dokumen sertifikat berhasil diupload.');
    }
}