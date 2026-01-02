<?php

namespace App\Helpers;

class Fonnte
{
    public static function send($target, $message)
    {
        $token = env("FONNTE_API_KEY");

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.fonnte.com/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                "target" => $target,
                "message" => $message,
            ],
            CURLOPT_HTTPHEADER => ["Authorization: $token"],
        ]);

        $response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        // Hanya log error, tidak log data sensitif
        if ($httpCode !== 200) {
            \Log::error("Fonnte: Gagal mengirim WA", ['http_code' => $httpCode]);
        }

        return $response;
    }
}
