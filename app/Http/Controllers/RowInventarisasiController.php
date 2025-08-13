<?php

namespace App\Http\Controllers;

use App\Models\Row;
use App\Models\RowInventarisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RowInventarisasiController extends Controller
{
    public function index(Row $row)
    {
        $inventarisasis = $row->row_inventarisasis()->latest()->get();
        return view('row.inventarisasi.index', compact('row', 'inventarisasis'));
    }

    public function create(Row $row)
    {
        return view('row.inventarisasi.create', compact('row'));
    }

    public function store(Request $request, Row $row)
    {
        $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        $path = null;
        if ($request->hasFile('lampiran_berita_acara')) {
            $path = $request->file('lampiran_berita_acara')->store('row_inventarisasi_files', 'public');
        }

        $row->row_inventarisasis()->create([
            'nama_kecamatan' => $request->nama_kecamatan,
            'status' => $request->status,
            'tanggal_pelaksanaan' => $request->tanggal_pelaksanaan,
            'lampiran_berita_acara' => $path,
        ]);

        return redirect()->route('row-inventarisasi.index', $row->id)
            ->with('success', 'Data inventarisasi ROW berhasil ditambahkan!');
    }

    public function edit(RowInventarisasi $rowInventarisasi)
    {
        return view('row.inventarisasi.edit', [
            'inventarisasi' => $rowInventarisasi,
            'row' => $rowInventarisasi->row,
        ]);
    }

    public function update(Request $request, RowInventarisasi $rowInventarisasi)
    {
        $validatedData = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($rowInventarisasi->lampiran_berita_acara) {
                Storage::disk('public')->delete($rowInventarisasi->lampiran_berita_acara);
            }
            $validatedData['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_inventarisasi_files', 'public');
        }

        $rowInventarisasi->update($validatedData);

        return redirect()->route('row-inventarisasi.index', $rowInventarisasi->row_id)
            ->with('success', 'Data inventarisasi ROW berhasil diperbarui!');
    }

    public function destroy(RowInventarisasi $rowInventarisasi)
    {
        if ($rowInventarisasi->lampiran_berita_acara) {
            Storage::disk('public')->delete($rowInventarisasi->lampiran_berita_acara);
        }

        $rowId = $rowInventarisasi->row_id;
        $rowInventarisasi->delete();

        return redirect()->route('row-inventarisasi.index', $rowId)
            ->with('success', 'Data inventarisasi ROW berhasil dihapus!');
    }
}
