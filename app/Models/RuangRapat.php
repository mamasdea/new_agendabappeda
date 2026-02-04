<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuangRapat extends Model
{
    protected $fillable = [
        'acara_rr',
        'bidang_rr',
        'jam_rr',
        'tanggal_rr',
        'tempat_rr',
        'ket_rr',
        'hari_tgl_rr',
    ];

    protected $casts = [
        'tanggal_rr' => 'date',
        'jam_rr' => 'datetime:H:i',
    ];
}
