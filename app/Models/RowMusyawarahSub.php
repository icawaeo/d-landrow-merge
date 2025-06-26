<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowMusyawarahSub extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     * Perlu didefinisikan karena nama model tidak mengikuti standar jamak Laravel.
     * @var string
     */
    protected $table = 'row_musyawarah_subs';

    /**
     * Kolom-kolom yang boleh diisi secara massal.
     * Pastikan semua nama kolom dari form Anda ada di sini.
     * @var array<int, string>
     */
    protected $fillable = [
        'row_id',
        'lokasi_musyawarah',
        'status',
        'tanggal_pelaksanaan',
        'file_berita_acara',
    ];

    /**
     * Mendefinisikan relasi bahwa data ini "milik" dari satu data Row.
     */
    public function row()
    {
        return $this->belongsTo(Row::class);
    }
}