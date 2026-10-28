<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('bphtb.sspd')]
#[Fillable([
    'tahun_sspd',
    'bulan_sspd',
    'no_urut_sspd',
    'kd_propinsi',
    'kd_dati2',
    'kd_tahun',
    'kd_bundel',
    'kd_no_urut',
    'kd_jns_pembayaran',
    'pembayaran_sspd_ke',
    'denda_sspd',
    'jml_sspd_yg_dibayar',
    'tgl_pembayaran_sspd',
    'tgl_rekam_byr_sspd',
    'perekam_byr_sspd_id',
])]
class Sspd extends Model
{
    use Compoships;
    protected $casts = [
        'tgl_pembayaran_sspd' => 'datetime',
        'tgl_rekam_byr_sspd' => 'datetime',
    ];
}
