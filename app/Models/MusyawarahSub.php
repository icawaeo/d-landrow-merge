<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MusyawarahSub extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara manual
    protected $table = 'musyawarah_subs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // PASTIKAN SEMUA KOLOM DARI FORM SUDAH ADA DI SINI
    protected $fillable = [
        'pengadaan_tanah_id',
        'nama_kecamatan',
        'status',
        'tanggal_pelaksanaan',
        'lampiran_berita_acara',
    ];

    /**
     * Mendefinisikan relasi ke PengadaanTanah.
     */
    public function pengadaanTanah()
    {
        return $this->belongsTo(PengadaanTanah::class);
    }
}