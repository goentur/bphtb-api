<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('bphtb.dat_perolehan_hak')]
#[Fillable([
    'tahun_perolehan',
    'bundel_perolehan',
    'no_urut_perolehan',
    'kd_propinsi',
    'kd_dati2',
    'kd_kecamatan',
    'kd_kelurahan',
    'kd_blok',
    'no_urut',
    'kd_jns_op',
    'ref_jph_id',
    'ref_jns_penetapan_id',
    'wp_penerima_hak_id',
    'wp_pemberi_hak_id',
    'ref_dok_tanah_id',
    'ref_hak_tanah_id',
    'no_dok_hak_tanah',
    'luas_bumi',
    'luas_bng',
    'nilai_kls_bumi',
    'nilai_kls_bng',
    'njop_pbb',
    'nilai_perolehan',
    'akumulasi_perolehan',
    'bagian_hak_penerima',
    'bagian_hak_total',
    'npop',
    'npoptkp',
    'npopkp',
    'tarif',
    'bphtb',
    'faktor_pengurang_bphtb',
    'bphtb_yg_harus_dibayar',
    'keterangan',
    'ppat_id',
    'status_pecahan',
    'status_berkas',
    'status_lampiran',
    'status_penelitian',
    'status_pengendalian',
    'status_verifikasi',
    'status_selesai',
    'tgl_lampiran',
    'lampiran_id',
    'tgl_penelitian',
    'penelitian_id',
    'tgl_pengendalian',
    'pengendalian_id',
    'tgl_verifikasi',
    'verifikasi_id',
    'tgl_selesai',
    'beda_luasan',
    'waris',
    'beda_luasan_bangunan',
    'status_ubah_data',
    'jenis_perolehan',
    'tgl_permohonan',
    'status_cs',
    'tahapan',
    'updated_at',
])]
class DatPerolehanHak extends Model
{
    use Compoships;
    protected $casts = [
        'tgl_lampiran' => 'datetime',
        'tgl_penelitian' => 'datetime',
        'tgl_pengendalian' => 'datetime',
        'tgl_verifikasi' => 'datetime',
        'tgl_selesai' => 'datetime',
        'tgl_permohonan' => 'datetime',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function datPengendalian()
    {
        return $this->hasOne(DatPengendalian::class, 'dat_perolehan_hak_id');
    }
}
