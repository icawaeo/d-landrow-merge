<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenHasil extends Model
{
    protected $table = 'dokumen_hasil';
    protected $fillable = ['no_surat', 'total_tip_luas', 'tgl_surat', 'file_path'];
}