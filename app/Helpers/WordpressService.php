<?php

namespace App\Helpers;

use App\Canal;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Traits\FileSystemLogic;

class WordpressService
{
    use FileSystemLogic;

    protected $api;
    protected $slug;

    public function __construct()
    {
        $canal = $canal = Canal::find(7);
        $canalUrl = $canal->options['back_url'];
        
        $this->api =  $canalUrl . "wp-json/pat/v1/";
    }

    public function getPosts($limit = 5)
    {
        $data = [
            'per_page' => $limit,
            'offset' => 1
        ];
        $url = $this->api . 'posts';
        
        return Curl::to($url)
        ->withData($data)
        ->asJsonResponse()
        ->get();
    }
    
}
