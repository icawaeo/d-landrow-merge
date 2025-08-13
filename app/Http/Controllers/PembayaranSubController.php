<?php
namespace App\Http\Controllers;
use App\Models\PengadaanTanah;
use App\Models\PembayaranSub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembayaranSubController extends Controller
{
    public function index(PengadaanTanah $pengadaanTanah)
    {
        $pembayarans = $pengadaanTanah->pembayaran_subs()->latest()->get();
        return view('pengadaan_tanah.pembayaran_sub.index', [
            'proyek' => $pengadaanTanah,
            'pembayarans' => $pembayarans
        ]);
    }

    public function create(PengadaanTanah $pengadaanTanah)
    {
        return view('pengadaan_tanah.pembayaran_sub.create', ['proyek' => $pengadaanTanah]);
    }

    public function store(Request $request, PengadaanTanah $pengadaanTanah)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('pembayaran_files', 'public');
        }

        $pengadaanTanah->pembayaran_subs()->create($data);
        return redirect()->route('pembayaran_sub.index', $pengadaanTanah->id)->with('success', 'Data pembayaran berhasil ditambahkan!');
    }
    public function edit(PembayaranSub $pembayaranSub)
    {
        return view('pengadaan_tanah.pembayaran_sub.edit', [
            'pembayaran' => $pembayaranSub,
            'proyek' => $pembayaranSub->pengadaanTanah
        ]);
    }

    public function update(Request $request, PembayaranSub $pembayaranSub)
    {
        $data = $request->validate([
            'nama_kecamatan' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'lampiran_berita_acara' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('lampiran_berita_acara')) {
            if ($pembayaranSub->lampiran_berita_acara) {
                Storage::disk('public')->delete($pembayaranSub->lampiran_berita_acara);
            }
            $data['lampiran_berita_acara'] = $request->file('lampiran_berita_acara')->store('pembayaran_files', 'public');
        }

        $pembayaranSub->update($data);
        return redirect()->route('pembayaran_sub.index', $pembayaranSub->pengadaan_tanah_id)->with('success', 'Data pembayaran berhasil diperbarui!');
    }

    public function destroy(PembayaranSub $pembayaranSub)
    {
        if ($pembayaranSub->lampiran_berita_acara) {
            Storage::disk('public')->delete($pembayaranSub->lampiran_berita_acara);
        }

        $pengadaanTanahId = $pembayaranSub->pengadaan_tanah_id;
        $pembayaranSub->delete();
        return redirect()->route('pembayaran_sub.index', $pengadaanTanahId)->with('success', 'Data pembayaran berhasil dihapus!');
    }

}