<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Musyawarah extends Model
{
    use HasFactory;

    protected $fillable = [
    'pengadaan_tanah_id',
    'no_tip',
    'nama_pemilik',
    'desa',
    'nilai',
    'status',
    'bukti_musyawarah',
    'status_pembayaran',
    'tanggal_pembayaran', 
    'bukti_pembayaran', 
];
    public function pengadaanTanah()
    {
        return $this->belongsTo(PengadaanTanah::class);
    }
}
