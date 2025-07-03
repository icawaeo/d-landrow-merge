<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\PembayaranMenu;
use App\Models\Penyampaian;

class PembayaranMenuController extends Controller
{
    public function index($rowId)
    {
        // Ambil semua penyampaian yang disetujui dari ROW ini
        $penyampaians = Penyampaian::where('row_id', $rowId)
            ->where('status_persetujuan', 'Setuju')
            ->with(['penetapanNilai', 'pembayaranMenu'])
            ->get();

        return view('row.pembayaran-menu.index', compact('penyampaians'));
    }

    public function store(Request $request, $penyampaianId)
    {
        $request->validate([
            'status' => 'required|in:TERBAYAR,BELUM TERBAYAR',
            'tanggal_pembayaran' => 'required|date',
            'bukti_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $filePath = $request->hasFile('bukti_dokumen') ? $request->file('bukti_dokumen')->store('pembayaran', 'public') : null;

        $penyampaian = \App\Models\Penyampaian::findOrFail($penyampaianId);

        if ($penyampaian->status_persetujuan !== 'Setuju') {
            return back()->with('error', 'Pembayaran hanya bisa ditambahkan untuk penyampaian yang disetujui.');
        }


        PembayaranMenu::create([
            'penyampaian_id' => $penyampaianId,
            'status' => $request->status,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
            'bukti_dokumen' => $filePath,
        ]);

        return back()->with('success', 'Data pembayaran berhasil ditambahkan.');
    }

    public function update(Request $request, PembayaranMenu $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:TERBAYAR,BELUM TERBAYAR',
            'tanggal_pembayaran' => 'required|date',
            'bukti_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('bukti_dokumen')) {
            Storage::disk('public')->delete($pembayaran->bukti_dokumen);
            $pembayaran->bukti_dokumen = $request->file('bukti_dokumen')->store('pembayaran', 'public');
        }

        $pembayaran->update([
            'status' => $request->status,
            'tanggal_pembayaran' => $request->tanggal_pembayaran,
        ]);

        return back()->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(PembayaranMenu $pembayaran)
    {
        if ($pembayaran->bukti_dokumen) {
            Storage::disk('public')->delete($pembayaran->bukti_dokumen);
        }

        $pembayaran->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
