<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyampaian extends Model
{
    use HasFactory;

    protected $table = 'penyampaian';
    protected $fillable = [
        'row_id',
        'penetapan_nilai_id',
        'no_bidang',
        'pemilik',
        'desa',
        'nilai',
        'status_persetujuan',
        'bukti_dokumen'
    ];

    // Relasi ke tabel rows (jika tetap digunakan)
    public function row()
    {
        return $this->belongsTo(Row::class);
    }

    // Relasi ke tabel penetapan_nilais
    public function penetapanNilai()
    {
        return $this->belongsTo(PenetapanNilai::class);
    }

    public function pembayaranMenu()
    {
        return $this->hasOne(PembayaranMenu::class, 'penyampaian_id');
    }

}
