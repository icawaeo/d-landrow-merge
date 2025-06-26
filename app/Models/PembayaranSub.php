<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSub extends Model
{
    use HasFactory;

    protected $table = 'pembayaran_subs';

    protected $fillable = [
        'pengadaan_tanah_id', 'nama_kecamatan', 'status', 'tanggal_pelaksanaan', 'lampiran_berita_acara',
    ];

    public function pengadaanTanah()
    {
        return $this->belongsTo(PengadaanTanah::class);
    }
}