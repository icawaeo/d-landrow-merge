<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowSosialisasi extends Model
{
    use HasFactory;
    protected $fillable = [
        'row_id', 'nama_kecamatan', 'status', 'tanggal_pelaksanaan', 'lampiran_berita_acara',
    ];
    public function row() { return $this->belongsTo(Row::class); }
}