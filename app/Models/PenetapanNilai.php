<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenetapanNilai extends Model
{
    use HasFactory;

    protected $fillable = [
        'row_id', 
        'span', 
        'no_bidang', 
        'nama_pemilik', 
        'desa', 
        'nilai_kompensasi'
    ];

    /**
     * Relasi ke model Penyampaian (One to One)
     */
    public function penyampaian()
    {
        return $this->hasOne(Penyampaian::class);
    }
}
