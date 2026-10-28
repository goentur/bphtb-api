<?php

namespace App\Repositories\Bpn;

use App\Http\Resources\PbbBpnResource;
use Illuminate\Support\Facades\DB;

class PbbBpnRepository
{
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

        $query = DB::table('PBB.DAT_OBJEK_PAJAK as DOP')
            ->join('PBB.REF_KELURAHAN as KEL', function ($join) {
                $join->on('DOP.KD_PROPINSI', 'KEL.KD_PROPINSI')
                    ->on('DOP.KD_DATI2', 'KEL.KD_DATI2')
                    ->on('DOP.KD_KECAMATAN', 'KEL.KD_KECAMATAN')
                    ->on('DOP.KD_KELURAHAN', 'KEL.KD_KELURAHAN');
            })
            ->join('PBB.REF_KECAMATAN as KEC', function ($join) {
                $join->on('KEL.KD_PROPINSI', 'KEC.KD_PROPINSI')
                    ->on('KEL.KD_DATI2', 'KEC.KD_DATI2')
                    ->on('KEL.KD_KECAMATAN', 'KEC.KD_KECAMATAN');
            })
            ->join('PBB.DAT_SUBJEK_PAJAK as DSP', function ($join) {
                $join->on('DOP.SUBJEK_PAJAK_ID', 'DSP.SUBJEK_PAJAK_ID');
            })
            ->leftJoin('PBB.DAT_TAGIHAN as DT', function ($join) {
                $join->on('DOP.KD_PROPINSI', 'DT.KD_PROPINSI')
                    ->on('DOP.KD_DATI2', 'DT.KD_DATI2')
                    ->on('DOP.KD_KECAMATAN', 'DT.KD_KECAMATAN')
                    ->on('DOP.KD_KELURAHAN', 'DT.KD_KELURAHAN')
                    ->on('DOP.KD_BLOK', 'DT.KD_BLOK')
                    ->on('DOP.NO_URUT', 'DT.NO_URUT')
                    ->on('DOP.KD_JNS_OP', 'DT.KD_JNS_OP');
            })
            ->select([
                "DOP.KD_PROPINSI",
                "DOP.KD_DATI2",
                "DOP.KD_KECAMATAN",
                "DOP.KD_KELURAHAN",
                "DOP.KD_BLOK",
                "DOP.NO_URUT",
                "DOP.KD_JNS_OP",
                "DOP.SUBJEK_PAJAK_ID",
                "DSP.NM_WP",
                "DOP.TOTAL_LUAS_BUMI",
                "DOP.TOTAL_LUAS_BNG",
                "DOP.NJOP_BUMI",
                "DOP.NJOP_BNG",
                "KEL.NM_KELURAHAN",
                "KEL.NM_KEL_BR",
                "KEC.NM_KECAMATAN",
                "DOP.JALAN_OP",
                "DOP.BLOK_KAV_NO_OP",
                "DOP.RT_OP",
                "DOP.RW_OP",
            ])
            ->addSelect(DB::raw("CASE WHEN DT.JML IS NULL THEN '100% LUNAS' ELSE 'BELUM LUNAS' END STATUS_TUNGGAKAN"))
            ->where("DOP.KD_PROPINSI", $nop1)
            ->where("DOP.KD_DATI2", $nop2)
            ->where("DOP.KD_KECAMATAN", $nop3)
            ->where("DOP.KD_KELURAHAN", $nop4)
            ->where("DOP.KD_BLOK", $nop5)
            ->where("DOP.NO_URUT", $nop6)
            ->where("DOP.KD_JNS_OP", $nop7)
            ->distinct()
            ->get()
            ->first();

        return (!$query)
            ? ["respon_code" => "Data tidak ditemukan"]
            : ["result" => PbbBpnResource::make($query), "respon_code" => "OK"];
    }
}
