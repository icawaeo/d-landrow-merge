<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranMenu extends Model
{
    use HasFactory;

    // Pastikan baris ini ada dan benar
    protected $table = 'pembayaran_menus';

    protected $fillable = [
        'penyampaian_id',
        'status',
        'tanggal_pembayaran',
        'bukti_dokumen',
    ];

    public function penyampaian()
    {
        return $this->belongsTo(Penyampaian::class);
    }
}