<?php

namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Perizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    /**
     * Menampilkan halaman perizinan.
     */
    public function edit(PengadaanTanah $pengadaanTanah)
    {
        $perizinan = Perizinan::firstOrCreate(['pengadaan_tanah_id' => $pengadaanTanah->id]);

        return view('pengadaan_tanah.perizinan', [
            'proyek' => $pengadaanTanah,
            'perizinan' => $perizinan,
        ]);
    }

    /**
     * Menyimpan file yang di-upload dari form.
     */
    public function store(Request $request, PengadaanTanah $pengadaanTanah)
    {
        $perizinan = Perizinan::firstOrCreate(['pengadaan_tanah_id' => $pengadaanTanah->id]);

        $rules = [
            'izin_penetapan_lokasi' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'],
        ];
        $wajibDiisi = ['izin_lingkungan', 'ikkpr', 'izin_prinsip'];

        foreach ($wajibDiisi as $field) {
            if (empty($perizinan->$field)) {
                $rules[$field] = ['required', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'];
            } else {
                $rules[$field] = ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'];
            }
        }
        
        $request->validate($rules);

        $dataToUpdate = [];
        $izinTypes = ['izin_lingkungan', 'ikkpr', 'izin_prinsip', 'izin_penetapan_lokasi'];

        foreach ($izinTypes as $type) {
            if ($request->hasFile($type)) {
                if ($perizinan->$type) {
                    Storage::disk('public')->delete($perizinan->$type);
                }
                $path = $request->file($type)->store('perizinan_files', 'public');
                $dataToUpdate[$type] = $path;
            }
        }

        $perizinan->update($dataToUpdate);

        return back()->with('success', 'Perubahan berhasil disimpan!');
    }
}