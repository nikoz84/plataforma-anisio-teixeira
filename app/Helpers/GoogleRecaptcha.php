<?php

namespace App\Helpers;

class GoogleRecaptcha
{
    /**
     * Validaçao codigo de segurança do recaptcha do Google
     * @param $response String cadeia de carecteres
     * @return array uma resposta em formato json
     */
    public function validate($recaptcha)
    {
        $secret = config('recaptcha.PRIVATE_KEY');
        $url = "https://www.google.com/recaptcha/api/siteverify";

        $data = [
            'secret' => $secret,
            'response' => $recaptcha
        ];
        $dataQuery = http_build_query($data);
        $length = strlen($dataQuery);

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n" .
                    "Content-Length: {$length}",
                'content' => $dataQuery
            ]
        ];
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $responseDecode = json_decode($response);
        
        $is_debug = env('APP_DEBUG');
        
        if ($is_debug == true) {
            return true;
        }

        return $responseDecode->success;
    }
}
