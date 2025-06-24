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
}