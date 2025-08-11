<?php

namespace App\Http\Controllers;

use App\Models\Row;
use App\Models\RowMusyawarahSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RowMusyawarahSubController extends Controller
{
    /**
     * Menampilkan halaman utama (tabel) untuk Musyawarah Sub pada proyek ROW tertentu.
     */
    public function index(Row $row)
    {
        $musyawarahs = $row->musyawarahSubs()->latest()->get();
        
        return view('row.musyawarah_sub.index', [
            'proyek' => $row,
            'musyawarahs' => $musyawarahs,
        ]);
    }

    /**
     * Menampilkan form untuk menambah data baru.
     */
    public function create(Row $row)
    {
        return view('row.musyawarah_sub.create', ['proyek' => $row]);
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request, Row $row)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_musyawarah_files', 'public');
        }

        $row->musyawarahSubs()->create($data);

        return redirect()->route('row.musyawarah_sub.index', $row->id)->with('success', 'Data musyawarah ROW berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(RowMusyawarahSub $musyawarahSub)
    {
        return view('row.musyawarah_sub.edit', [
            'musyawarah' => $musyawarahSub,
            'proyek' => $musyawarahSub->row, // Mengambil data proyek dari relasi
        ]);
    }

    /**
     * Memperbarui data di database.
     */
    public function update(Request $request, RowMusyawarahSub $musyawarahSub)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($musyawarahSub->lampiran_berita_acara) {
                Storage::disk('public')->delete($musyawarahSub->lampiran_berita_acara);
            }
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('row_musyawarah_files', 'public');
        }

        $musyawarahSub->update($data);

        return redirect()->route('row.musyawarah_sub.index', $musyawarahSub->row_id)->with('success', 'Data musyawarah ROW berhasil diperbarui!');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(RowMusyawarahSub $musyawarahSub)
    {
        if ($musyawarahSub->lampiran_berita_acara) {
            Storage::disk('public')->delete($musyawarahSub->lampiran_berita_acara);
        }
        
        $rowId = $musyawarahSub->row_id;
        $musyawarahSub->delete();

        return redirect()->route('row.musyawarah_sub.index', $rowId)->with('success', 'Data musyawarah ROW berhasil dihapus!');
    }
}