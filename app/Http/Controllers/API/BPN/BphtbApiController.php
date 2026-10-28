<?php

namespace App\Http\Controllers\API\BPN;

use App\Http\Controllers\Controller;
use App\Repositories\Bpn\BphtbBpnRepository;
use App\Support\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BphtbApiController extends Controller
{
    public function __construct(protected BphtbBpnRepository $repository) {}

    public function index(Request $request)
    {
        $input = $request->json()->all();
        if (empty($input)) {
            $input = $request->all();
        }
        $validator = Validator::make($input, [
            'NOP' => 'required|digits:18',
            'NTPD' => 'required|digits:15',
        ]);

        if ($validator->fails()) {
            $message = "Data tidak ditemukan";
            $errors = $validator->errors();

            if ($errors->has('NOP')) $message = "NOP tidak ditemukan";
            if ($errors->has('NTPD')) $message = "NTPD tidak ditemukan";

            return response()->json([
                "respon_code" => $message
            ], 200);
        }

        return ApiResponse::make($this->repository->show($validator->validated()));
    }
    public function getStatusNIBService(Request $request)
    {

        $input = $request->json()->all();
        if (empty($input)) {
            $input = $request->all();
        }
        $validator = Validator::make($input, [
            'NIB' => 'required|string|min_digits:13|max_digits:20',
        ]);

        if ($validator->fails()) {
            $code = "error";
            $message = "";
            $errors = $validator->errors();

            if ($errors->has('NIB')) $message = "NIB Tidak Ditemukan";

            return response()->json([
                "respon_code" => $code,
                "STATUS" => "-",
                "KETERANGAN" => $message,
            ], 200);
        }

        return ApiResponse::make($this->repository->cekNib($validator->validated()));
    }
}
