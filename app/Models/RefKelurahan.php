<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefKelurahan extends Model
{
    use Compoships;

    protected $table = 'pbb.ref_kelurahan';

    protected $primaryKey = [
        'kd_propinsi',
        'kd_dati2',
        'kd_kecamatan',
        'kd_kelurahan',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [];

    protected $hidden = [];

    /**
     * Accessor untuk nama kelurahan.
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nm_kelurahan,
        );
    }

    /**
     * Relasi ke RefPropinsi (single key).
     */
    public function refPropinsi(): BelongsTo
    {
        return $this->belongsTo(RefPropinsi::class, 'kd_propinsi', 'kd_propinsi');
    }

    /**
     * Relasi composite ke RefDati2 (2 keys via Compoships).
     */
    public function refDati2()
    {
        return $this->belongsTo(RefDati2::class, ['kd_propinsi', 'kd_dati2'], ['kd_propinsi', 'kd_dati2']);
    }

    /**
     * Relasi composite ke RefKecamatan (3 keys via Compoships).
     */
    public function refKecamatan()
    {
        return $this->belongsTo(RefKecamatan::class, ['kd_propinsi', 'kd_dati2', 'kd_kecamatan'], ['kd_propinsi', 'kd_dati2', 'kd_kecamatan']);
    }
}
