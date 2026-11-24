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
            'USERNAME' => 'required|string|digits:11',
            'PASSWORD' => 'required|string|digits:8',
            'NOP' => 'required|digits:18',
            'NTPD' => 'required|digits:15',
        ]);
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = "Data tidak ditemukan";

            if ($errors->has('NOP')) {
                $message = "NOP tidak ditemukan";
            } elseif ($errors->has('NTPD')) {
                $message = "NTPD tidak ditemukan";
            } elseif ($errors->has('USERNAME') || $errors->has('PASSWORD')) {
                $message = "Username atau Password tidak valid";
            }

            return response()->json([
                "respon_code" => $message
            ], 200);
        }

        if ($input['USERNAME'] !== 'pusdatinbpn' || $input['PASSWORD'] !== 'pusdatin') {
            return response()->json([
                "respon_code" => "Username atau Password salah"
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
            'NIB' => 'required|string|min_digits:13|max_digits:14',
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
