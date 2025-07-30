<?php

namespace App\Http\Controllers;

use App\Models\PenetapanNilai;
use App\Models\Row;
use Illuminate\Http\Request;

class PenetapanNilaiController extends Controller
{
    public function index(Row $row, Request $request)
    {
        $span = $request->input('span', '1 ke 2');
        $data = PenetapanNilai::where('row_id', $row->id)
                        ->where('span', $span)
                        ->get();
        return view('row.penetapan-nilai.index', compact('data', 'row', 'span'));
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
        return redirect()->route('row.penetapan-nilai.index', $row->id)->with('success', 'Data berhasil ditambahkan');
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
        $data = PenetapanNilai::where('row_id', $row->id)->get();
        $itemToEdit = PenetapanNilai::findOrFail($id);
        $span = $itemToEdit->span;
        return view('row.penetapan-nilai.index', compact('data', 'row', 'span', 'itemToEdit'));
    }


    public function destroy(Row $row, $id)
    {
        $nilai = PenetapanNilai::findOrFail($id);
        $span = $nilai->span;
        $nilai->delete();
        return redirect()->route('row.penetapan-nilai.index', [$row->id, 'span' => $span])->with('success', 'Data berhasil dihapus');
    }
}