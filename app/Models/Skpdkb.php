<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;

#[Table('bphtb.skpdkb')]
#[Fillable([
    'tahun_skpdkb',
    'bundel_skpdkb',
    'no_urut_skpdkb',
    'kd_propinsi',
    'kd_dati2',
    'kd_kecamatan',
    'kd_kelurahan',
    'kd_blok',
    'no_urut',
    'kd_jns_op',
    'sptpd_id',
    'skpdkb_ke',
    'nilai_perolehan_skpdkb',
    'akumulasi_perolehan',
    'bagian_hak_penerima',
    'bagian_hak_total',
    'npop',
    'npoptkp',
    'npopkp',
    'tarif',
    'bphtb',
    'bphtb_skpdkb',
    'faktor_pengurang_skpdkb',
    'bphtb_yg_telah_dibayar',
    'bphtb_yg_harus_dibayar_skpdkb',
    'tgl_jatuh_tempo_skpdkb',
    'kodebayar',
    'ppat_id',
    'verifikator_id',
    'legitimator_id',
    'status_pembayaran_skpdkb',
    'status_tagihan_skpdkb', // 0 Belum, 1 Aktif, 2 Batal
    'status_cetak_skpdkb', // Dokumen TTE: 0 Belum, 1 Selesai, 2 Gagal, 3 Dikirim
    'tgl_terbit_skpdkb',
    'tgl_cetak_skpdkb', // Dokumen TTE
    'tgl_akses_bpn',
    'tgl_selesai_bpn',
])]
class Skpdkb extends Model
{
    use Compoships;

    public function sptpdWithPerolehanHak()
    {
        return $this->belongsTo(Sptpd::class, 'sptpd_id')->with('datPerolehanHakWithPengendalian');
    }

    public function sspd()
    {
        return $this->hasOne(Sspd::class, ['kd_tahun', 'kd_bundel', 'kd_no_urut'], ['tahun_skpdkb', 'bundel_skpdkb', 'no_urut_skpdkb']);
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
