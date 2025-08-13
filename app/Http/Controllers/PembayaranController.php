<?php
namespace App\Http\Controllers;

use App\Models\PengadaanTanah;
use App\Models\Musyawarah; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class PembayaranController extends Controller
{

    public function index(PengadaanTanah $pengadaanTanah)
    {
        $pembayaranItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();
        return view('pengadaan_tanah.pembayaran.index', [
            'proyek' => $pengadaanTanah,
            'pembayaranItems' => $pembayaranItems
        ]);
    }


    public function edit(Musyawarah $item)
    {
        $pengadaanTanah = $item->pengadaanTanah;
        $pembayaranItems = $pengadaanTanah->musyawarahs()->orderBy('no_tip')->get();

        return view('pengadaan_tanah.pembayaran.index', [
            'proyek' => $pengadaanTanah,
            'pembayaranItems' => $pembayaranItems,
            'itemToEdit' => $item 
        ]);
    }

    
    public function update(Request $request, Musyawarah $item)
    {
        $data = $request->validate([
            'status_pembayaran' => 'required|string',
            'tanggal_pembayaran' => 'required|date',
            'bukti_pembayaran' => 'nullable|file|mimes:pdf,jpg,png,docx|max:5120',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($item->bukti_pembayaran && Storage::disk('public')->exists($item->bukti_pembayaran)) {
                Storage::disk('public')->delete($item->bukti_pembayaran);
            }
            $data['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $item->update($data);

        return redirect()->route('pembayaran.index', $item->pengadaan_tanah_id)->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function exportPdf(PengadaanTanah $proyek)
    {
        $pembayaranItems = $proyek->musyawarahs()->orderBy('no_tip')->get();

        $pdf = PDF::loadView('pengadaan_tanah.pembayaran.pdf', [
            'pembayaranItems' => $pembayaranItems,
            'proyek' => $proyek,
        ]);

        $fileName = 'laporan-pembayaran-' . Str::slug($proyek->nama_proyek) . '.pdf';

        return $pdf->stream($fileName);
    }
}