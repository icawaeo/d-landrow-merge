<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyampaian;
use App\Models\PenetapanNilai;
use App\Models\Row;
use Illuminate\Support\Facades\Storage;

class PenyampaianController extends Controller
{
    public function index(Row $row, Request $request)
    {
        $spanFilter = $request->input('span');

        $spans = PenetapanNilai::where('row_id', $row->id)
            ->select('span')
            ->distinct()
            ->pluck('span');

        $penetapanNilais = PenetapanNilai::with('penyampaian')
            ->where('row_id', $row->id)
            ->when($spanFilter, function ($query) use ($spanFilter) {
                $query->where('span', $spanFilter);
            })
            ->get();

        return view('row.penyampaian.index', compact('penetapanNilais', 'spans', 'spanFilter', 'row'));
    }

    public function store(Request $request, $penetapanNilaiId)
    {
        $request->validate([
            'status' => 'required',
            'bukti_dokumen' => 'required|file|max:5120',
        ]);

        $filePath = $request->file('bukti_dokumen')->store('penyampaian', 'public');

        $penetapanNilai = \App\Models\PenetapanNilai::findOrFail($penetapanNilaiId);

        Penyampaian::create([
            'penetapan_nilai_id' => $penetapanNilaiId,
            'row_id' => $penetapanNilai->row_id, // 👈 tambahkan ini
            'status_persetujuan' => $request->status,
            'bukti_dokumen' => $filePath,
        ]);

        return back()->with('success', 'Data berhasil disimpan.');
    }

    public function update(Request $request, Penyampaian $penyampaian)
    {
        $validated = $request->validate([
            'status_persetujuan' => 'required|string',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Handle file baru jika ada
        if ($request->hasFile('bukti_dokumen')) {
            if ($penyampaian->bukti_dokumen && Storage::disk('public')->exists($penyampaian->bukti_dokumen)) {
                Storage::disk('public')->delete($penyampaian->bukti_dokumen);
            }

            $validated['bukti_dokumen'] = $request->file('bukti_dokumen')->store('penyampaian', 'public');
        }

        $penyampaian->update($validated);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(Penyampaian $penyampaian)
    {
        // Hapus file dari storage jika ada
        if ($penyampaian->bukti_dokumen && Storage::disk('public')->exists($penyampaian->bukti_dokumen)) {
            Storage::disk('public')->delete($penyampaian->bukti_dokumen);
        }

        // Hapus data
        $penyampaian->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function deleteFile(Penyampaian $penyampaian)
    {
        if ($penyampaian->bukti_dokumen && Storage::disk('public')->exists($penyampaian->bukti_dokumen)) {
            Storage::disk('public')->delete($penyampaian->bukti_dokumen);
            $penyampaian->update(['bukti_dokumen' => null]);
        }

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
