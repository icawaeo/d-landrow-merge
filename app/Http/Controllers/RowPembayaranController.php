<?php

namespace App\Http\Controllers;

use App\Models\Row;
use App\Models\RowPembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RowPembayaranController extends Controller
{
    public function index(Row $row)
    {
        $pembayarans = $row->row_pembayarans()->latest()->get();
        return view('row.pembayaran.index', [
            'row' => $row,
            'pembayarans' => $pembayarans
        ]);
    }

    public function create(Row $row)
    {
        return view('row.pembayaran.create', ['row' => $row]);
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
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_pembayaran_files', 'public');
        }

        $row->row_pembayarans()->create($data);
        return redirect()->route('row.pembayaran.index', $row->id)->with('success', 'Data pembayaran berhasil ditambahkan!');
    }

    public function edit(RowPembayaran $pembayaran)
    {
        return view('row.pembayaran.edit', [
            'pembayaran' => $pembayaran,
            'row' => $pembayaran->row
        ]);
    }

    public function update(Request $request, RowPembayaran $pembayaran)
    {
        // PERBAIKAN: Salin kembali aturan validasi dari method store()
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($pembayaran->lampiran_berita_acara) {
                Storage::disk('public')->delete($pembayaran->lampiran_berita_acara);
            }
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_pembayaran_files', 'public');
        }

        $pembayaran->update($data);
        return redirect()->route('row.pembayaran.index', $pembayaran->row_id)->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy(RowPembayaran $pembayaran)
    {
        if ($pembayaran->lampiran_berita_acara) {
            Storage::disk('public')->delete($pembayaran->lampiran_berita_acara);
        }

        $rowId = $pembayaran->row_id;
        $pembayaran->delete();
        return redirect()->route('row.pembayaran.index', $rowId)->with('success', 'Data pembayaran berhasil dihapus!');
    }
}