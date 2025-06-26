<?php
namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Musyawarah; // Kita menggunakan model Musyawarah
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // Menampilkan halaman Pembayaran
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $pembayaranItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();
        return view('pengadaan_tanah.pembayaran.index', [
            'proyek' => $pengadaanTanah,
            'pembayaranItems' => $pembayaranItems
        ]);
    }

    // Mengupdate data pembayaran untuk satu item
    public function update(Request $request, Musyawarah $item)
    {
        $data = $request->validate([
            'status_pembayaran' => 'required|string',
            'tanggal_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($item->bukti_pembayaran && \Storage::disk('public')->exists($item->bukti_pembayaran)) {
                \Storage::disk('public')->delete($item->bukti_pembayaran);
            }
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $item->update($data);

        return back()->with('success', 'Data pembayaran untuk ' . $item->nama_pemilik . ' berhasil diperbarui.');
    }
}