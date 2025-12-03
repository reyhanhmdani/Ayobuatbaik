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
        curl_close($curl);

        \Log::info("FONNTE SEND:", [
            "target" => $target,
            "message" => $message,
            "response" => $response,
        ]);

        return $response;
    }
}
