<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('bphtb.dat_pengendalian')]
#[Fillable([
    'dat_perolehan_hak_id',
    'keterangan',
    'status_pengendalian',
    'tgl_pengendalian',
    'pengendalian_id',
])]
class DatPengendalian extends Model
{
    use Compoships;

    protected $casts = [
        'tgl_pengendalian' => 'datetime',
    ];
}
