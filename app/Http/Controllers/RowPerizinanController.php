<?php

namespace App\Http\Controllers;

use App\Models\Row;
use App\Models\RowPerizinan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RowPerizinanController extends Controller
{
    public function edit(Row $row)
    {
        $perizinan = RowPerizinan::firstOrCreate(['row_id' => $row->id]);

        return view('row.perizinan', [
            'proyek' => $row,
            'perizinan' => $perizinan,
        ]);
    }

    public function store(Request $request, Row $row)
    {
        $perizinan = RowPerizinan::firstOrCreate(['row_id' => $row->id]);

        $rules = [
            'izin_penetapan_lokasi' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'],
        ];
        // Aturan wajib sesuai permintaan terakhir Anda
        $wajibDiisi = ['izin_lingkungan', 'izin_rt_rw', 'izin_prinsip'];

        foreach ($wajibDiisi as $field) {
            if (empty($perizinan->$field)) {
                $rules[$field] = ['required', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'];
            } else {
                $rules[$field] = ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png', 'max:5120'];
            }
        }

        $request->validate($rules);

        $dataToUpdate = [];
        $izinTypes = ['izin_lingkungan', 'izin_rt_rw', 'izin_prinsip', 'izin_penetapan_lokasi'];

        foreach ($izinTypes as $type) {
            if ($request->hasFile($type)) {
                if ($perizinan->$type) {
                    Storage::disk('public')->delete($perizinan->$type);
                }
                $path = $request->file($type)->store('perizinan_files_row', 'public');
                $dataToUpdate[$type] = $path;
            }
        }

        $perizinan->update($dataToUpdate);

        return back()->with('success', 'Perubahan berhasil disimpan!');
    }
}