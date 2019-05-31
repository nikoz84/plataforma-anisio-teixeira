<?php

namespace App\Helpers;

use App\Canal;

class WordpressService
{
    protected $api;

    public function __construct()
    {
        $canal = $canal = Canal::find(7);
        $canalUrl = $canal->options['back_url'];

        $this->api =  $canalUrl . "/wp-json/wp/v2/";
    }

    public function getPosts($limit = 3)
    {
        $end_point = "posts";
        $data = [
            'per_page' => $limit,
            '_embed' => true
        ];
        $posts = $this->getData($data, $end_point);

        return $this->createArray($posts);
    }
    // Extrai o arquivo json e transforma em objeto de PHP
    private function getData($data, $end_point)
    {

        $data_query = http_build_query($data, $end_point);
        $length = strlen($data_query);
        $options = [
            'http' => [
                'method' => 'GET',
                'header' => "Content-Type: application/json\r\n" .
                    "Content-Length: {$length}",
                'content' => $data_query
            ]
        ];

        $context  = stream_context_create($options);
        $request = file_get_contents($this->api . $end_point, true, $context);
        print_r($request);
        die();
        $data = json_decode($request, false);

        return $data;
    }
    private function createArray($posts)
    {
        $data = []; // posts

        if (!$posts) {
            return;
        }
        $count = 0;

        foreach ($posts as $post) {
            if ($post->status == 'publish') {
                // procura se tem imagem destacada ou no corpo como anexo
                $linkMedia = ($post->featured_media) ? $post->_links->{"wp:featuredmedia"}[0]->href : $post->_links->{"wp:attachment"}[0]->href;
                // objeto do post
                $date = date_create($post->date);
                $data_publicacao = ($date) ? date_format($date, 'd/m/y H:m:s') : date('d/m/y H:m:s');

                $data[$count] = [
                    'id' => $post->id,
                    'created_at' => $data_publicacao,
                    'title' => $post->title->rendered,
                    'exerpt' => $post->excerpt->rendered,
                    'link' => $post->link,
                    'author' => $post->_embedded->author[0]->name,
                    //'image' => $this->getFeaturedMedia($post->featured_media, $linkMedia)
                ];
            }

            $count++;
        }
        return $data;
    }

    // Extrai imagem de destaque ou busca dentro das imagens dentro do post
    private function getFeaturedMedia($isFeaturedMedia, $linkMedia)
    {
        $media = $this->getData($linkMedia);

        switch (true) {
            case ($isFeaturedMedia):
                return $media->media_details->sizes->featured->source_url;
                break;
            case (count($media)):
                return $media[0]->media_details->sizes->{"featured-blog-medium"}->source_url;
                break;
            default:
                return "/img/img-fundo-padrao.svg";
        }
    }
}
