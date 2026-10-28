<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Coba ambil dari request standar (Parsed JSON / Form Data)
        $clientKey = $request->input('KEY');

        // 2. Jika tidak ditemukan, parse dari Raw Body Content
        if (!$clientKey) {
            $rawContent = $request->getContent();
            $data = json_decode($rawContent, true);

            if (is_array($data) && isset($data['KEY'])) {
                $clientKey = $data['KEY'];
            }
        }

        // 3. Validasi keakuratan KEY
        if (!$clientKey || $clientKey !== config('services.bpn.key')) {
            return response()->json([
                'respon_code' => 'Invalid API Key'
            ], 401);
        }

        return $next($request);
    }
}
