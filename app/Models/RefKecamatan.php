<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefKecamatan extends Model
{
    use Compoships;

    protected $table = 'pbb.ref_kecamatan';

    protected $primaryKey = [
        'kd_propinsi',
        'kd_dati2',
        'kd_kecamatan',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [];

    protected $hidden = [];

    /**
     * Accessor untuk nama kecamatan.
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nm_kecamatan,
        );
    }

    /**
     * Relasi ke RefPropinsi.
     */
    public function refPropinsi(): BelongsTo
    {
        return $this->belongsTo(RefPropinsi::class, 'kd_propinsi', 'kd_propinsi');
    }

    /**
     * Relasi composite ke RefDati2 (menggunakan Compoships).
     */
    public function refDati2()
    {
        return $this->belongsTo(RefDati2::class, ['kd_propinsi', 'kd_dati2'], ['kd_propinsi', 'kd_dati2']);
    }
}
