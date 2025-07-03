<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranMenu extends Model
{
    protected $table = 'pembayaran-menu';

    protected $fillable = [
        'penyampaian_id',
        'status',
        'tanggal_pembayaran',
        'bukti_dokumen'
    ];

    public function penyampaian()
    {
        return $this->belongsTo(Penyampaian::class);
    }
}