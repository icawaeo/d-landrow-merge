<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sertifikat;
use Illuminate\Support\Facades\Storage;

class SertifikatController extends Controller
{
    public function index()
    {
        return view('pengadaan_tanah.sertifikat.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'no_tip' => 'required',
            'x' => 'required',
            'y' => 'required',
        ]);

        $result = Sertifikat::where('no_tip', $request->no_tip)
            ->where('x', $request->x)
            ->where('y', $request->y)
            ->first();

        return view('pengadaan_tanah.sertifikat', compact('result'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,jpg,png|max:2048',
        ]);

        $sertifikat = Sertifikat::findOrFail($id);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('sertifikat', 'public');
            $sertifikat->file_path = $path;
            $sertifikat->save();
        }

        return redirect()->back()->with('success', 'Dokumen sertifikat berhasil diupload.');
    }
}
