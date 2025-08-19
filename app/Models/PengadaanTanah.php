<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DokumenHasil;
use App\Models\User;

class PengadaanTanah extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_proyek',
        'kategori',
        'jumlah_tower',
        'provinsi',
        'kabupaten',
        'kecamatan',
        'desa',
        'status_persetujuan',
        'admin1_id',
        'admin1_reviewed_at',
        'admin2_id',
        'admin2_reviewed_at',
        'admin3_id',
        'admin3_reviewed_at',
        'catatan_penolakan',
        'is_viewed'
    ];

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perizinan()
    {
        return $this->hasOne(Perizinan::class);
    }

    public function sosialisasis()
    {
    return $this->hasMany(Sosialisasi::class);
    }

    public function inventarisasis()
    {
    return $this->hasMany(Inventarisasi::class);
    }

    public function musyawarah_subs()
    {
    return $this->hasMany(MusyawarahSub::class);
    }

    public function pembayaran_subs()
    {
    return $this->hasMany(PembayaranSub::class);
    }
    
    public function musyawarahs()
    {
    return $this->hasMany(Musyawarah::class);
    }

    // public function pembayarans()
    // {
    //     return $this->hasOne(PembayaranController::class);
    // }

    public function dokumen_hasil()
    {
        return $this->hasMany(DokumenHasil::class, 'pengadaan_tanah_id');
    }
}