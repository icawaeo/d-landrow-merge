<?php

namespace App\Http\Controllers;

use App\Models\PenetapanNilai;
use App\Models\Penyampaian; 
use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenetapanNilaiController extends Controller
{
    public function index(Row $row, Request $request)
    {
        $spanFilter = $request->input('span');

        $dbSpans = PenetapanNilai::where('row_id', $row->id)
            ->whereNotNull('span')
            ->select('span')
            ->distinct()
            ->pluck('span');

        $spans = $dbSpans;
            if ($spanFilter && !$spans->contains($spanFilter)) {
                $spans->push($spanFilter);
            }

        $penetapanNilais = PenetapanNilai::with('penyampaian')
            ->where('row_id', $row->id)
            ->when($spanFilter, function ($query, $spanFilter) {
                if ($spanFilter !== '') {
                    return $query->where('span', $spanFilter);
                }
                return $query;
            })
            ->get();

        return view('row.penetapan-nilai.index', compact('penetapanNilais', 'spans', 'spanFilter', 'row'));
    }


    public function store(Request $request, Row $row)
    {
        // HAPUS baris pembersihan otomatis di sini

        $validated = $request->validate([
            'span' => 'required',
            'no_bidang' => 'required',
            'nama_pemilik' => 'required',
            'desa' => 'required',
            // UBAH aturan validasi ini
            'nilai_kompensasi' => 'required|integer', 
        ]);

        $validated['row_id'] = $row->id;
        PenetapanNilai::create($validated);

        return redirect()->route('row.penetapan-nilai.index', [
            'row' => $row->id, 
            'span' => $validated['span']
        ])->with('success', 'Data berhasil ditambahkan');
    }

    public function update(Request $request, Row $row, $id)
    {
        // HAPUS baris pembersihan otomatis di sini

        $validated = $request->validate([
            'no_bidang' => 'required',
            'nama_pemilik' => 'required',
            'desa' => 'required',
            // UBAH aturan validasi ini
            'nilai_kompensasi' => 'required|integer',
        ]);

        $nilai = PenetapanNilai::findOrFail($id);
        $nilai->update($validated);
        return redirect()->route('row.penetapan-nilai.index', [$row->id, 'span' => $nilai->span])->with('success', 'Data berhasil diperbarui');
    }


    public function edit(Row $row, $id)
    {
        $itemToEdit = PenetapanNilai::findOrFail($id);

        $spanFilter = $itemToEdit->span;

        $dbSpans = PenetapanNilai::where('row_id', $row->id)
            ->whereNotNull('span')
            ->select('span')
            ->distinct()
            ->pluck('span');

        $spans = $dbSpans;
        if ($spanFilter && !$spans->contains($spanFilter)) {
            $spans->push($spanFilter);
        }

        $penetapanNilais = PenetapanNilai::where('row_id', $row->id)
            ->where('span', $spanFilter)
            ->get();

        return view('row.penetapan-nilai.index', compact(
            'penetapanNilais', 
            'spans', 
            'spanFilter', 
            'row', 
            'itemToEdit'
        ));
    }


    public function destroy(Row $row, $id)
    {
        $nilai = PenetapanNilai::findOrFail($id);
        $span = $nilai->span;
        $nilai->delete();
        return redirect()->route('row.penetapan-nilai.index', [$row->id, 'span' => $span])->with('success', 'Data berhasil dihapus');
    }

    public function storeSpan(Request $request, Row $row)
    {
        $validated = $request->validate([
            'start_tip' => 'required|integer|min:1',
            'end_tip' => 'required|integer|gt:start_tip',
        ]);

        $startBidang = $validated['start_tip'];
        $endBidang = $validated['end_tip'];
        $spanName = $startBidang . ' ke ' . $endBidang;

        $spanExists = PenetapanNilai::where('row_id', $row->id)
        ->where('span', $spanName)
        ->exists();

        if ($spanExists) {
            $message = "Menampilkan data untuk span {$startBidang}–{$endBidang}.";
        } else {
            $message = "Span {$startBidang}–{$endBidang} berhasil dibuat.";
        }

        return redirect()->route('row.penetapan-nilai.index', [
            'row' => $row->id,
            'span' => $spanName
        ])->with('success', $message);
    }
}