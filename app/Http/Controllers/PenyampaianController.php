<?php

namespace App\Http\Controllers;

use App\Models\Penyampaian;
use App\Models\PenetapanNilai;
use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PenyampaianController extends Controller
{
    /**
     * Menampilkan data Penetapan Nilai beserta status Penyampaian-nya.
     */
    public function index(Row $row, Request $request)
    {
        $spanFilter = $request->input('span');

        $spans = PenetapanNilai::where('row_id', $row->id)
            ->select('span')
            ->distinct()
            ->pluck('span');

        $penetapanNilais = PenetapanNilai::with('penyampaian')
            ->where('row_id', $row->id)
            ->when($spanFilter, function ($query, $spanFilter) {
                $query->where('span', $spanFilter);
            })
            ->get();

        return view('row.penyampaian.index', compact('penetapanNilais', 'spans', 'spanFilter', 'row'));
    }

    /**
     * Menyimpan data Penyampaian baru untuk sebuah Penetapan Nilai.
     */
    public function store(Request $request, Row $row, PenetapanNilai $penetapanNilai)
    {
        $validated = $request->validate([
            'status_persetujuan' => 'required|string|in:Setuju,Menolak',
            'dokumen_penyampaian' => 'required|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen_penyampaian')) {
            $validated['dokumen_penyampaian'] = $request->file('dokumen_penyampaian')->store('penyampaian_docs', 'public');
        }

        $validated['penetapan_nilai_id'] = $penetapanNilai->id;
        $validated['row_id'] = $row->id;

        Penyampaian::create($validated);

        return back()->with('success', 'Data penyampaian berhasil disimpan.');
    }

    /**
     * PERBAIKAN: Mengupdate hanya status dan dokumen.
     */
    public function update(Request $request, Penyampaian $penyampaian)
    {
        $validated = $request->validate([
            'status_persetujuan' => 'required|string|in:Setuju,Menolak',
            'dokumen_penyampaian' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
        ]);

        if ($request->hasFile('dokumen_penyampaian')) {
            if ($penyampaian->dokumen_penyampaian && Storage::disk('public')->exists($penyampaian->dokumen_penyampaian)) {
                Storage::disk('public')->delete($penyampaian->dokumen_penyampaian);
            }
            $validated['dokumen_penyampaian'] = $request->file('dokumen_penyampaian')->store('penyampaian_docs', 'public');
        }

        $penyampaian->update($validated);

        return back()->with('success', 'Data penyampaian berhasil diperbarui.');
    }

    /**
     * Fungsi destroy tidak lagi digunakan.
     */
}
