<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perizinan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengadaan_tanah_id',
        'izin_lingkungan',
        'ikkpr',
        'izin_prinsip',
        'izin_penetapan_lokasi',
    ];

    public function pengadaanTanah()
    {
        return $this->belongsTo(PengadaanTanah::class);
    }
}