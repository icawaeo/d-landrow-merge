<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Row extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_proyek',
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
    ];
    public function row_perizinans()
    {
        return $this->hasMany(RowPerizinan::class);
    }

    public function row_sosialisasis()
    {
        return $this->hasMany(RowSosialisasi::class);
    }
    
    public function row_inventarisasis()
    {
        return $this->hasMany(RowInventarisasi::class);
    }
    
    public function row_musyawarah_subs()
    {
        return $this->hasMany(RowMusyawarahSub::class);
    }

    public function row_pembayarans()
    {
        return $this->hasMany(RowPembayaran::class);
    }

    public function penetapan_nilais()
    {
        return $this->hasMany(PenetapanNilai::class);
    }

    public function penyampaians()
    {
        return $this->hasManyThrough(Penyampaian::class, PenetapanNilai::class);
    }

    // public function pembayaran_menus()
    // {
    //     return $this->hasManyThrough(PembayaranMenu::class, Penyampaian::class);
    // }
}