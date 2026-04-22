<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhatsAppWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Proses Verifikasi (Hanya saat pertama kali setup di Dashboard Meta)
        if ($request->isMethod('get')) {
            $verifyToken = 'tokabe_keren_2024'; // Isi bebas, nanti samakan di Meta Dashboard

            if ($request->query('hub_verify_token') === $verifyToken) {
                return response($request->query('hub_challenge'), 200);
            }
            return response('Token Tidak Cocok', 403);
        }

        // 2. Proses Terima Pesan (POST request dari Meta)
        $data = $request->all();

        // Catat di log agar kamu bisa lihat strukturnya di storage/logs/laravel.log
        Log::info('WhatsApp Webhook Data:', $data);

        // Respon Meta dengan 200 OK agar mereka tidak mengirim ulang pesan yang sama
        return response('EVENT_RECEIVED', 200);
    }
}