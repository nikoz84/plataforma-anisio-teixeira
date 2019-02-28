<?php

namespace App\Helpers;

class GoogleRecaptcha
{
    public function __construct($request)
    {
        $this->ip = $request->getClientIp();
        $this->recaptcha =  $request->get('recaptcha');
    }

    /**
     * Validaçao codigo de segurança do recaptcha do Google
     * @param $response String cadeia de carecteres
     * @return array uma resposta em formato json
     */
    public function validateRecaptcha()
    {
        $secret = env('CAPTCHA_SECRET_KEY');
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $url .= "?secret={$secret}&response={$this->recaptcha}&ip={$this->ip}";
        return file_get_contents($url, false);
    }
}
