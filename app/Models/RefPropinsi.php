<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefPropinsi extends Model
{

    protected $table = 'ref_propinsi';

    protected $primaryKey = 'kd_propinsi';

    protected $keyType = 'string';

    protected $fillable = [
        'kd_propinsi',
        'nm_propinsi',
    ];

    protected $hidden = [];

    public function getNamaAttribute()
    {
        return $this->nm_propinsi;
    }
}
