<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarisasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengadaan_tanah_id',
        'nama_kecamatan',
        'status',
        'tanggal_pelaksanaan',
        'lampiran_berita_acara',
    ];
}