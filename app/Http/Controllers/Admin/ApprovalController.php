<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengadaanTanah;
use App\Models\Row;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    public function index()
    {
        $userRole = Auth::user()->role;
        $projectsForReview = [];

        if ($userRole === 'admin1') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_1')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_1')->get();
            $projectsForReview = $pengadaanTanah->concat($row);
        } elseif ($userRole === 'admin2') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_2')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_2')->get();
            $projectsForReview = $pengadaanTanah->concat($row);
        } elseif ($userRole === 'admin3') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_3')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_3')->get();
            $projectsForReview = $pengadaanTanah->concat($row);
        }

        return view('admin.dashboard', ['projects' => $projectsForReview]);
    }

    public function decide(Request $request, $type, $id)
    {
        $request->validate([
            'decision' => 'required|in:setuju,tolak',
            'catatan_penolakan' => 'nullable|string',
        ]);

        $project = $type === 'pengadaan-tanah' ? PengadaanTanah::findOrFail($id) : Row::findOrFail($id);
        $user = Auth::user();
        $now = now();

        $decisionData = [
            "admin{$user->role[-1]}_id" => $user->id,
            "admin{$user->role[-1]}_reviewed_at" => $now,
        ];

        if ($request->decision === 'tolak') {
            $decisionData['status_persetujuan'] = "ditolak_{$user->role}";
            $decisionData['catatan_penolakan'] = $request->catatan_penolakan;
        } else {
            if ($user->role === 'admin1') {
                $decisionData['status_persetujuan'] = 'menunggu_admin_2';
            } elseif ($user->role === 'admin2') {
                $decisionData['status_persetujuan'] = 'menunggu_admin_3';
            } elseif ($user->role === 'admin3') {
                $decisionData['status_persetujuan'] = 'disetujui';
            }
        }

        $project->update($decisionData);

        return redirect()->route('admin.dashboard')->with('success', 'Keputusan berhasil disimpan.');
    }
}