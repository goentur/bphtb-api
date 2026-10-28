<?php

namespace App\Http\Controllers\API\BPN;

use App\Http\Controllers\Controller;
use App\Repositories\Bpn\PbbBpnRepository;
use App\Support\Response\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PbbApiController extends Controller
{
    public function __construct(protected PbbBpnRepository $repository) {}

    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'NOP' => 'required|digits:18',
        ]);

        if ($validator->fails()) {
            $message = "Data tidak ditemukan";
            $errors = $validator->errors();

            if ($errors->has('NOP')) $message = "NOP tidak ditemukan";

            return response()->json([
                "respon_code" => $message
            ], 200);
        }

        return ApiResponse::make($this->repository->show($validator->validated()));
    }
}
