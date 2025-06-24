<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RowPerizinan extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama kolom baru
    protected $fillable = [
        'row_id',
        'izin_lingkungan',
        'izin_rt_rw', 
        'izin_prinsip',
        'izin_penetapan_lokasi',
    ];

    // Definisikan relasi ke model Row
    public function row()
    {
        return $this->belongsTo(Row::class);
    }
}