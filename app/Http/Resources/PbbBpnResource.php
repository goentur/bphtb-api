<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PbbBpnResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'NOP' =>
            $this->kd_propinsi .
                $this->kd_dati2 .
                $this->kd_kecamatan .
                $this->kd_kelurahan .
                $this->kd_blok .
                $this->no_urut .
                $this->kd_jns_op,
            'NIK' => trim($this->subjek_pajak_id),
            'NAMA_WP' => $this->nm_wp,
            'ALAMAT_OP' => $this->jalan_op . ' ' . $this->blok_kav_no_op
                . ' RT.' . $this->rt_op . '/RW.' . $this->rw_op,
            'KELURAHAN_OP' => $this->nm_kel_br ?? $this->nm_kelurahan,
            'KECAMATAN_OP' => $this->nm_kecamatan,
            'KOTA_OP' => 'KOTA PEKALONGAN',
            'LUASTANAH_OP' => (int) $this->total_luas_bumi,
            'LUASBANGUNAN_OP' => (int) $this->total_luas_bng,
            'NJOP_TANAH_OP' => (int) $this->njop_bumi,
            'NJOP_BANGUNAN_OP' => (int) $this->njop_bng,
            'STATUS_TUNGGAKAN' => $this->status_tunggakan,
        ];
    }
}
