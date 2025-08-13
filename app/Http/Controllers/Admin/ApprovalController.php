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
        $projectsForReview = collect();
        $approvedProjects = collect();

        if ($userRole === 'admin1') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_1')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_1')->get();
            $projectsForReview = $pengadaanTanah->concat($row);

            $approvedPengadaanTanah = PengadaanTanah::where('admin1_id', Auth::id())
                                        ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                                        ->get();
            $approvedRow = Row::where('admin1_id', Auth::id())
                            ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                            ->get();
            $approvedProjects = $approvedPengadaanTanah->concat($approvedRow);

        } elseif ($userRole === 'admin2') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_2')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_2')->get();
            $projectsForReview = $pengadaanTanah->concat($row);

            $approvedPengadaanTanah = PengadaanTanah::where('admin2_id', Auth::id())
                                        ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                                        ->get();
            $approvedRow = Row::where('admin2_id', Auth::id())
                            ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                            ->get();
            $approvedProjects = $approvedPengadaanTanah->concat($approvedRow);

        } elseif ($userRole === 'admin3') {
            $pengadaanTanah = PengadaanTanah::where('status_persetujuan', 'menunggu_admin_3')->get();
            $row = Row::where('status_persetujuan', 'menunggu_admin_3')->get();
            $projectsForReview = $pengadaanTanah->concat($row);

            $approvedPengadaanTanah = PengadaanTanah::where('admin3_id', Auth::id())
                                        ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                                        ->get();
            $approvedRow = Row::where('admin3_id', Auth::id())
                            ->whereNotIn('status_persetujuan', ['ditolak_admin1', 'ditolak_admin2', 'ditolak_admin3'])
                            ->get();
            $approvedProjects = $approvedPengadaanTanah->concat($approvedRow);
        }

        return view('admin.dashboard', [
            'projects' => $projectsForReview,
            'approvedProjects' => $approvedProjects
        ]);
    }

    public function decide(Request $request, $type, $id)
    {
        $request->validate([
            'decision' => 'required|in:setuju,tolak',
            'catatan_penolakan' => 'required_if:decision,tolak|string|nullable',
        ]);

        $project = $type === 'pengadaan-tanah' ? PengadaanTanah::findOrFail($id) : Row::findOrFail($id);
        $user = Auth::user();
        $now = now();

        $decisionData = [];

        if ($request->decision === 'setuju') {
            $decisionData["admin{$user->role[-1]}_id"] = $user->id;
            $decisionData["admin{$user->role[-1]}_reviewed_at"] = $now;

            if ($user->role === 'admin1') {
                $decisionData['status_persetujuan'] = 'menunggu_admin_2';
            } elseif ($user->role === 'admin2') {
                $decisionData['status_persetujuan'] = 'menunggu_admin_3';
            } elseif ($user->role === 'admin3') {
                $decisionData['status_persetujuan'] = 'disetujui';
            }
        } else {
            $decisionData['status_persetujuan'] = "ditolak_{$user->role}";
            $decisionData['catatan_penolakan'] = $request->catatan_penolakan;
            $decisionData['admin1_id'] = null;
            $decisionData['admin1_reviewed_at'] = null;
            $decisionData['admin2_id'] = null;
            $decisionData['admin2_reviewed_at'] = null;
            $decisionData['admin3_id'] = null;
            $decisionData['admin3_reviewed_at'] = null;
        }

        $project->update($decisionData);

        return redirect()->route('admin.dashboard')->with('success', 'Keputusan berhasil disimpan.');
    }

    public function show($type, $id)
    {
        $project = null;

        if ($type === 'pengadaan-tanah') {
            $project = \App\Models\PengadaanTanah::with([
                'perizinan',
                'sosialisasis',
                'inventarisasis',
                'musyawarah_subs',
                'pembayaran_subs',
                'musyawarahs',
                // 'pembayarans',
                'dokumen_hasil'
            ])->findOrFail($id);

        } elseif ($type === 'row') {
            $project = \App\Models\Row::with([
                'row_perizinans', 
                'row_sosialisasis', 
                'row_inventarisasis', 
                'row_musyawarah_subs', 
                'row_pembayarans',
                'penetapan_nilais',
                'penyampaians',
                'pembayaran_menus'
            ])->findOrFail($id);

        } else {
            abort(404);
        }

        return view('admin.detail-project', [
            'project' => $project,
            'type' => $type
        ]);
    }
}