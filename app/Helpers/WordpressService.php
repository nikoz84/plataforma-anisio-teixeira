<?php

namespace App\Helpers;

use App\Canal;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Str;

class WordpressService
{
    protected $api;
    protected $slug;

    public function __construct()
    {
        $canal = $canal = Canal::find(7);
        $canalUrl = $canal->options['back_url'];
        $this->slug = $canal->slug;
        $this->api =  $canalUrl . "/wp-json/wp/v2/";
    }

    public function getPosts($limit = 5)
    {
        $data = [
            'per_page' => $limit,
            '_embed' => true
        ];
        $url = $this->api . 'posts';

        return $this->createArray($this->getData($url, $data));
    }
    public function getPost($request)
    {
        $url = $this->api . "posts/{$request->id}&_embed=true";

        return Curl::to($url)
            ->asJsonResponse()
            ->get();
    }
    public function getData($url = '', $data = null)
    {
        return Curl::to($url)
            ->withData($data)
            ->asJsonResponse()
            ->get();
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
                $linkMedia = ($post->featured_media) ?
                    $post->_links->{"wp:featuredmedia"}[0]->href : $post->_links->{"wp:attachment"}[0]->href;
                // objeto do post
                $date = date_create($post->date);
                $data_publicacao = ($date) ? date_format($date, 'd/m/y H:m:s') : date('d/m/y H:m:s');

                $data[$count] = [
                    'id' => $post->id,
                    'created_at' => $data_publicacao,
                    'title' => $post->title->rendered,
                    'exerpt' => strip_tags(Str::words($post->excerpt->rendered, 30)),
                    'link' => $post->link,
                    'author' => $post->_embedded->author[0]->name,
                    'slug' => $this->slug,
                    'image' => $this->getFeaturedMedia($post->featured_media, $linkMedia)
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
                return null; //$media->media_details->sizes->featured->source_url;
                break;
            case (count($media)):
                return $media[0]->media_details->sizes->{"featured-blog-medium"}->source_url;
                break;
            default:
                return "/img/img-fundo-padrao.svg";
        }
    }
}
