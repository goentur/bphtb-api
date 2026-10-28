<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefDati2 extends Model
{
    use Compoships;

    protected $table = 'pbb.ref_dati2';

    protected $primaryKey = [
        'kd_propinsi',
        'kd_dati2',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [];

    protected $hidden = [];

    /**
     * Accessor untuk nama dati2.
     */
    protected function nama(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->nm_dati2,
        );
    }

    /**
     * Relasi ke RefPropinsi.
     */
    public function refPropinsi(): BelongsTo
    {
        return $this->belongsTo(RefPropinsi::class, 'kd_propinsi', 'kd_propinsi');
    }
}
