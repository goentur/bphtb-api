<?php

namespace App\Repositories\Bpn;

use App\Models\Skpdkb;
use App\Models\Sptpd;

class BphtbBpnRepository
{
    public function __construct() {}
    public function show($request)
    {
        $nop = $request['NOP']; //  length 18
        $nop1 = substr($nop, 0, 2);
        $nop2 = substr($nop, 2, 2);
        $nop3 = substr($nop, 4, 3);
        $nop4 = substr($nop, 7, 3);
        $nop5 = substr($nop, 10, 3);
        $nop6 = substr($nop, 13, 4);
        $nop7 = substr($nop, 17, 1);

        $ntpd = $request['NTPD']; // length 15
        $ntpd1 = substr($ntpd, 0, 2); // 33
        $ntpd2 = substr($ntpd, 2, 2); // 75
        $ntpd3 = substr($ntpd, 4, 4); // TAHUN
        $ntpd4 = substr($ntpd, 8, 4); // BUNDEL
        $ntpd5 = substr($ntpd, 12, 3); // NO URUT

        $kb = !str_starts_with($ntpd4, '0');
        if ($ntpd3 < (date('Y') - 1)) {
            return ["respon_code" => "Data tidak ditemukan"];
        }
        $tanggalSudahDiubah = now();
        if ($kb) {
            $skp = Skpdkb::with(['sptpdWithPerolehanHak', 'sspd', 'refDati2', 'refKecamatan', 'refKelurahan'])
                ->where('tahun_skpdkb', $ntpd3)
                ->where('bundel_skpdkb', $ntpd4)
                ->where('no_urut_skpdkb', $ntpd5)
                ->where('kd_propinsi', $nop1)
                ->where('kd_dati2', $nop2)
                ->where('kd_kecamatan', $nop3)
                ->where('kd_kelurahan', $nop4)
                ->where('kd_blok', $nop5)
                ->where('no_urut', $nop6)
                ->where('kd_jns_op', $nop7)
                ->first();

            if (!$skp) {
                return ["respon_code" => "Data tidak ditemukan"];
            }
            if ($skp) {
                if (!$skp->sspd) {
                    return ["respon_code" => "Data tidak ditemukan"];
                }
                // $skp->timestamps = false;
                // $skp->tgl_akses_bpn = $tanggalSudahDiubah;
                // $skp->save();
                // if ($skp->sptpd) {
                //     $skp->sptpd->timestamps = false;
                //     $skp->sptpd->tgl_akses_bpn = $tanggalSudahDiubah;
                //     $skp->sptpd->save();
                // }
            }

            return $this->showkb($skp);
        }

        $spt = Sptpd::with(['datPerolehanHakWithPengendalian', 'sspd', 'skpdkbWithSspd', 'refDati2', 'refKecamatan', 'refKelurahan'])
            ->where('tahun_sptpd', $ntpd3)
            ->where('bundel_sptpd', $ntpd4)
            ->where('no_urut_sptpd', $ntpd5)
            ->where('kd_propinsi', $nop1)
            ->where('kd_dati2', $nop2)
            ->where('kd_kecamatan', $nop3)
            ->where('kd_kelurahan', $nop4)
            ->where('kd_blok', $nop5)
            ->where('no_urut', $nop6)
            ->where('kd_jns_op', $nop7)
            ->first();

        if (!$spt) {
            return ["respon_code" => "Data tidak ditemukan"];
        }
        if ($spt) {
            if (!$spt->sspd) {
                return ["respon_code" => "Data tidak ditemukan"];
            }
            // $spt->timestamps = false;
            // $spt->tgl_akses_bpn = $tanggalSudahDiubah;
            // $spt->save();
        }

        $statusBayar = 'T';
        if ($spt->status_pembayaran_sptpd == 1 && $spt->sspd) {
            if ($spt->datPerolehanHakWithPengendalian && $spt->datPerolehanHakWithPengendalian->datPengendalian && $spt->datPerolehanHakWithPengendalian->datPengendalian->status_pengendalian === '1') {
                $statusBayar = 'Y';
            } else if ($spt->datPerolehanHakWithPengendalian && $spt->datPerolehanHakWithPengendalian->datPengendalian && $spt->datPerolehanHakWithPengendalian->datPengendalian->status_pengendalian === '2') {
                if ($spt->skpdkbWithSspd && $spt->skpdkbWithSspd->status_pembayaran_skpdkb == 1 && $spt->skpdkbWithSspd->sspd) {
                    $statusBayar = 'Y';
                } else {
                    $statusBayar = 'B';
                }
            } else {
                $statusBayar = 'B';
            }
        }
        return [
            "respon_code" => "OK",
            "result" => [
                "NOP" => $spt->kd_propinsi . $spt->kd_dati2 . $spt->kd_kecamatan . $spt->kd_kelurahan . $spt->kd_blok . $spt->no_urut . $spt->kd_jns_op,
                "NIK" => trim($spt->nid_wp_sptpd),
                "NAMA" => $spt->nama_wp_sptpd,
                "ALAMAT" => $spt->alamat_wp_sptpd . ' RT.' . $spt->rt_wp_sptpd . '/RW.' . $spt->rw_wp_sptpd . ' KEL. ' . $spt->kelurahan_wp_sptpd . ' KEC. ' . $spt->kecamatan_wp_sptpd . ' ' . $spt->kota_wp_sptpd,
                "KELURAHAN_OP" => $spt->refKelurahan->nm_kel_br ?? $spt->refKelurahan->nama,
                "KECAMATAN_OP" => $spt->refKecamatan->nama,
                "KOTA_OP" => $spt->refDati2->nama,
                "LUASTANAH" => (int) $spt->luas_bumi,
                "LUASBANGUNAN" => (int) $spt->luas_bng,
                "PEMBAYARAN" => (int) $spt->bphtb_yg_harus_dibayar,
                "STATUS" => $statusBayar,
                "TANGGAL_PERMOHONAN" => $spt->datPerolehanHakWithPengendalian ? $spt->datPerolehanHakWithPengendalian->updated_at->format('d/m/Y') : null,
                "TANGGAL_KODEBILLING" => $spt->sspd ? $spt->tgl_perolehan_hak_sptpd->format('d/m/Y') : null,
                "TANGGAL_PEMBAYARAN" => $spt->sspd ? $spt->sspd->tgl_pembayaran_sspd->format('d/m/Y') : null,
                "TANGGAL_VALIDASI" => ($spt->datPerolehanHakWithPengendalian && $spt->datPerolehanHakWithPengendalian->datPengendalian) ? $spt->datPerolehanHakWithPengendalian->datPengendalian->tgl_pengendalian->format('d/m/Y') : null,
                "NTPD" => $spt->kd_propinsi . $spt->kd_dati2 . $spt->tahun_sptpd . $spt->bundel_sptpd . $spt->no_urut_sptpd,
                "JENISBAYAR" => ($spt->status_pembayaran_sptpd == 1 && $spt->sspd) ? 'L' : 'H',
            ],
        ];
    }

    public function showkb(Skpdkb $spt)
    {
        return [
            "respon_code" => "OK",
            "result" => [
                "NOP" => $spt->kd_propinsi . $spt->kd_dati2 . $spt->kd_kecamatan . $spt->kd_kelurahan . $spt->kd_blok . $spt->no_urut . $spt->kd_jns_op,
                "NIK" => trim($spt->sptpdWithPerolehanHak->nid_wp_sptpd),
                "NAMA" => $spt->sptpdWithPerolehanHak->nama_wp_sptpd,
                "ALAMAT" => $spt->sptpdWithPerolehanHak->alamat_wp_sptpd . ' RT.' . $spt->sptpdWithPerolehanHak->rt_wp_sptpd . '/RW.' . $spt->sptpdWithPerolehanHak->rw_wp_sptpd . ' KEL. ' . $spt->sptpdWithPerolehanHak->kelurahan_wp_sptpd . ' KEC. ' . $spt->sptpdWithPerolehanHak->kecamatan_wp_sptpd . ' ' . $spt->sptpdWithPerolehanHak->kota_wp_sptpd,
                "KELURAHAN_OP" => $spt->refKelurahan->nm_kel_br ?? $spt->refKelurahan->nama,
                "KECAMATAN_OP" => $spt->refKecamatan->nama,
                "KOTA_OP" => $spt->refDati2->nama,
                "LUASTANAH" => (int) $spt->sptpdWithPerolehanHak->luas_bumi,
                "LUASBANGUNAN" => (int) $spt->sptpdWithPerolehanHak->luas_bng,
                "PEMBAYARAN" => (int) ($spt->bphtb_skpdkb - $spt->faktor_pengurang_skpdkb),
                "STATUS" => ($spt->status_pembayaran_skpdkb == 1 && $spt->sspd) ? 'Y' : 'B',
                "TANGGAL_PERMOHONAN" => $spt->sptpdWithPerolehanHak->datPerolehanHakWithPengendalian ? $spt->sptpdWithPerolehanHak->datPerolehanHakWithPengendalian->updated_at->format('d/m/Y') : null,
                "TANGGAL_KODEBILLING" => $spt->sptpdWithPerolehanHak ? $spt->sptpdWithPerolehanHak->tgl_perolehan_hak_sptpd->format('d/m/Y') : null,
                "TANGGAL_PEMBAYARAN" => $spt->sspd ? $spt->sspd->tgl_pembayaran_sspd->format('d/m/Y') : null,
                "TANGGAL_VALIDASI" => ($spt->sptpdWithPerolehanHak->datPerolehanHakWithPengendalian && $spt->sptpdWithPerolehanHak->datPerolehanHakWithPengendalian->datPengendalian) ? $spt->sptpdWithPerolehanHak->datPerolehanHakWithPengendalian->datPengendalian->tgl_pengendalian->format('d/m/Y') : null,
                "NTPD" => $spt->kd_propinsi . $spt->kd_dati2 . $spt->tahun_skpdkb . $spt->bundel_skpdkb . $spt->no_urut_skpdkb,
                "JENISBAYAR" => ($spt->status_pembayaran_skpdkb == 1 && $spt->sspd) ? 'L' : 'H',
            ],
        ];
    }

    public function cekNib($request)
    {
        $spt = Sptpd::with(['datPerolehanHakWithPengendalian', 'sspd', 'skpdkbWithSspd'])
            ->where('no_dok_hak_tanah', $request['NIB'])
            ->first();

        if (!$spt) {
            return $this->formatResponse("T", "Tidak Ditemukan Pembayaran");
        }

        $statusPengendalian = $spt->datPerolehanHakWithPengendalian?->datPengendalian?->status_pengendalian;
        $skpdkb = $spt->skpdkbWithSspd;

        $isSptLunas = $spt->status_pembayaran_sptpd == 1 && $spt->sspd;
        $isStatus1Valid = $statusPengendalian === '1';
        $isStatus2Valid = $statusPengendalian === '2' && $skpdkb?->status_pembayaran_skpdkb == 1 && $skpdkb?->sspd;

        if ($isSptLunas && ($isStatus1Valid || $isStatus2Valid)) {
            return $this->formatResponse("Y", "Sudah Validasi Pembayaran");
        }

        return $this->formatResponse("B", "Menunggu Validasi Pembayaran");
    }

    private function formatResponse(string $status, string $keterangan): array
    {
        return [
            "result" => [
                "STATUS" => $status,
                "KETERANGAN" => $keterangan,
            ]
        ];
    }
}
