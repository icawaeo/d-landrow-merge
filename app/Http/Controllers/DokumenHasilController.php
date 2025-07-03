<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenHasil;
use Illuminate\Support\Facades\Storage;

class DokumenHasilController extends Controller
{
    public function index()
    {
        $dokumen = DokumenHasil::all();
        return view('/pengadaan_tanah/dokumenhasil', compact('dokumen'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx|max:2048',
        ]);

        $dokumen = DokumenHasil::findOrFail($id);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('dokumenhasil', 'public');
            $dokumen->file_path = $path;
            $dokumen->save();
        }

        return redirect()->back()->with('success', 'Dokumen berhasil diupload.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'no_surat' => 'required|string|max:255',
            'total_tip_luas' => 'required|string|max:255',
            'tgl_surat' => 'required|date',
        ]);

        DokumenHasil::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan.');
    }
}
