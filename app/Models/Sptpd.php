<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Table('bphtb.sptpd')]
#[Fillable([
    'tahun_sptpd',
    'bundel_sptpd',
    'no_urut_sptpd',
    'kd_propinsi',
    'kd_dati2',
    'kd_kecamatan',
    'kd_kelurahan',
    'kd_blok',
    'no_urut',
    'kd_jns_op',
    'dat_perolehan_hak_id',
    'ref_jph_id',
    'ref_jns_penetapan_id',
    'nid_wp_sptpd',
    'npwp_wp_sptpd',
    'nama_wp_sptpd',
    'alamat_wp_sptpd',
    'rw_wp_sptpd',
    'rt_wp_sptpd',
    'kelurahan_wp_sptpd',
    'kecamatan_wp_sptpd',
    'kota_wp_sptpd',
    'kode_pos_wp_sptpd',
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
    'tgl_jatuh_tempo_sptpd',
    'kodebayar',
    'ppat_id',
    'verifikator_id',
    'legitimator_id',
    'status_pembayaran_sptpd',
    'status_tagihan_sptpd',
    'status_cetak_sptpd',
    'tgl_perolehan_hak_sptpd',
    'tgl_terbit_sptpd',
    'tgl_cetak_sptpd',
    'tgl_akses_bpn',
    'tgl_selesai_bpn'
])]

class Sptpd extends Model
{
    use Compoships;

    protected $casts = [
        'tgl_jatuh_tempo_sptpd' => 'date',
        'tgl_perolehan_hak_sptpd' => 'date',
        'tgl_terbit_sptpd' => 'datetime',
        'tgl_cetak_sptpd' => 'datetime',
    ];
    public function datPerolehanHakWithPengendalian(): BelongsTo
    {
        return $this->belongsTo(DatPerolehanHak::class, 'dat_perolehan_hak_id')->with('datPengendalian');
    }

    public function sspd()
    {
        return $this->hasOne(Sspd::class, ['kd_tahun', 'kd_bundel', 'kd_no_urut'], ['tahun_sptpd', 'bundel_sptpd', 'no_urut_sptpd']);
    }

    public function skpdkbWithSspd()
    {
        return $this->hasOne(Skpdkb::class, 'sptpd_id')->with('sspd');
    }

    public function refDati2()
    {
        return $this->belongsTo(RefDati2::class, ['kd_propinsi', 'kd_dati2'], ['kd_propinsi', 'kd_dati2']);
    }

    public function refKecamatan()
    {
        return $this->belongsTo(RefKecamatan::class, ['kd_propinsi', 'kd_dati2', 'kd_kecamatan'], ['kd_propinsi', 'kd_dati2', 'kd_kecamatan']);
    }

    public function refKelurahan()
    {
        return $this->belongsTo(RefKelurahan::class, ['kd_propinsi', 'kd_dati2', 'kd_kecamatan', 'kd_kelurahan'], ['kd_propinsi', 'kd_dati2', 'kd_kecamatan', 'kd_kelurahan']);
    }
}
