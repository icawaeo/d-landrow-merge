<?php

namespace App\Http\Controllers;

use App\Models\Row;
use Illuminate\Http\Request;

class RowController extends Controller
{
    public function create()
    {
        return view('row.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'jumlah_tower' => 'nullable|integer',
        ]);

        Row::create($request->all());

        return redirect()->route('homepage')->with('success', 'Data ROW berhasil dibuat!');
    }
        /**
     * Menampilkan form untuk mengedit data ROW.
     */
    public function edit(Row $row)
    {
        // Kirim data ROW yang spesifik ke view 'edit.blade.php'
        return view('row.edit', [
            'proyek' => $row,
            'judul' => 'Edit Data ROW: ' . $row->nama_proyek
        ]);
    }

    /**
     * Memperbarui data ROW di database.
     */
    public function update(Request $request, Row $row)
    {
        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'jumlah_tower' => 'nullable|integer',
        ]);

        $row->update($request->all());

        return redirect()->route('homepage')->with('success', 'Data ROW berhasil diperbarui!');
    }

    /**
     * Menghapus data ROW dari database.
     */
    public function destroy(Row $row)
    {
        $row->delete();

        return redirect()->route('homepage')->with('success', 'Data ROW berhasil dihapus!');
    }

    /**
     * Mengajukan ROW untuk persetujuan.
     */
    public function submitForApproval(Row $row)
    {
        $row->update([
            'status_persetujuan' => 'menunggu_admin_1',
            'catatan_penolakan' => null,
        ]);
        return redirect()->route('homepage')->with('success', 'Proyek berhasil diajukan untuk persetujuan.');
    }
}