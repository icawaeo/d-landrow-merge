<?php

namespace App\Http\Controllers;

use App\Models\Row;
use App\Models\RowSosialisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RowSosialisasiController extends Controller
{
    public function index(Row $row)
    {
        $sosialisasis = $row->sosialisasis()->latest()->get();
        return view('row.sosialisasi.index', [
            'proyek' => $row,
            'sosialisasis' => $sosialisasis,
        ]);
    }

    public function create(Row $row)
    {
        return view('row.sosialisasi.create', ['proyek' => $row]);
    }

    public function store(Request $request, Row $row)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_sosialisasi_files', 'public');
        }

        $row->sosialisasis()->create($data);
        return redirect()->route('row.sosialisasi.index', $row->id)->with('success', 'Data sosialisasi ROW berhasil ditambahkan!');
    }

    public function edit(RowSosialisasi $sosialisasi)
    {
        return view('row.sosialisasi.edit', [
            'sosialisasi' => $sosialisasi,
            'proyek' => $sosialisasi->row,
        ]);
    }

    public function update(Request $request, RowSosialisasi $sosialisasi)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($sosialisasi->lampiran_berita_acara) {
                Storage::disk('public')->delete($sosialisasi->lampiran_berita_acara);
            }
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_sosialisasi_files', 'public');
        }

        $sosialisasi->update($data);
        return redirect()->route('row.sosialisasi.index', $sosialisasi->row_id)->with('success', 'Data sosialisasi ROW berhasil diperbarui!');
    }

    public function destroy(RowSosialisasi $sosialisasi)
    {
        if ($sosialisasi->lampiran_berita_acara) {
            Storage::disk('public')->delete($sosialisasi->lampiran_berita_acara);
        }
        
        $rowId = $sosialisasi->row_id;
        $sosialisasi->delete();
        return redirect()->route('row.sosialisasi.index', $rowId)->with('success', 'Data sosialisasi ROW berhasil dihapus!');
    }
}