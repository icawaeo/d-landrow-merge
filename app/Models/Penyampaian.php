<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyampaian extends Model
{
    use HasFactory;

    /**
     * Dengan tidak mendefinisikan $table, Laravel akan otomatis
     * menggunakan nama tabel jamak 'penyampaians'. Ini adalah praktik terbaik.
     */

    protected $fillable = [
        'row_id',
        'penetapan_nilai_id',
        'status_persetujuan',
        'tanggal_penyampaian',
        'dokumen_penyampaian',
        'catatan',
    ];

    /**
     * Relasi ke model Row.
     */
    public function row()
    {
        return $this->belongsTo(Row::class);
    }

    /**
     * Relasi ke model PenetapanNilai.
     */
    public function penetapanNilai()
    {
        return $this->belongsTo(PenetapanNilai::class);
    }

    /**
     * Relasi ke model PembayaranMenu.
     */
    public function pembayaranMenu()
    {
        return $this->hasOne(PembayaranMenu::class);
    }

    /**
     * Relasi ke model Tip.
     */
    public function tip()
    {
        return $this->belongsTo(Tip::class);
    }
}
