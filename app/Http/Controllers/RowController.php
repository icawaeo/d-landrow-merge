<?php

namespace App\Http\Controllers;

use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $data = $request->all();
        $data['user_id'] = Auth::id();

        Row::create($data);

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
            'is_viewed' => false
        ]);
        
        return redirect()->route('homepage')->with('success', 'Proyek berhasil diajukan untuk persetujuan.');
    }

    /**
     * Menampilkan detail ROW.
     */
    public function show(Row $row)
    {
        $isReview = Auth::guard('admin')->check();
        return view('row.show', compact('row', 'isReview'));
    }

    public function dashboard(Row $row)
    {
        $terbayarCount = $row->penyampaians()
            ->where('status_persetujuan', 'Setuju')
            ->whereHas('pembayaranMenu', function ($query) {
                $query->where('status', 'TERBAYAR');
            })
            ->count();
            
        $belumTerbayarCount = $row->penyampaians()
            ->where('status_persetujuan', 'Setuju')
            ->where(function ($query) {
                $query->whereDoesntHave('pembayaranMenu')
                      ->orWhereHas('pembayaranMenu', function ($q) {
                          $q->where('status', '!=', 'TERBAYAR');
                      });
            })
            ->count();

        $paymentData = [
            'Terbayar' => $terbayarCount,
            'Belum Terbayar' => $belumTerbayarCount,
        ];

        return view('row.dashboard', [
            'proyek' => $row,
            'paymentData' => json_encode($paymentData) // Kirim sebagai JSON
        ]);
    }
}