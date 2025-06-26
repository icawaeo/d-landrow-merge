<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanTanah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
        'kategori',
        'jumlah_tower',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
    ];
    public function sosialisasis()
    {
    return $this->hasMany(Sosialisasi::class);
    }

    public function inventarisasis()
    {
    return $this->hasMany(Inventarisasi::class);
    }

    public function musyawarahSubs()
    {
    return $this->hasMany(MusyawarahSub::class);
    }

    // di dalam class PengadaanTanah
    public function pembayaranSubs()
    {
    return $this->hasMany(PembayaranSub::class);
    }
    
    public function musyawarahs()
    {
    return $this->hasMany(Musyawarah::class);
    }
}