<?php

namespace App\Helpers;


define("URL_WORDPRESS_API",'/wp-json/wp/v2/');

class WordpressService
{
    private $api;
    public function __construct(){
        
        $this->api = $this->getCanal()->getUrlcanal().URL_WORDPRESS_API;
    }
    private function getCanal()
    {
        
    }
    
    // http://blog.pat.educacao.ba.gov.br/wp-json/wp/v2/posts?per_page=10
    public function getPosts($limit = 4){
        $urlPosts = $this->api."posts?per_page={$limit}&_embed=true";
        $posts= $this->getData($urlPosts);  
        return $this->createArray($posts);
    }
    private function createArray($posts){
        $data = (object)[]; // posts
        
        if(!$posts) return;
        $count = 0;
        
        foreach($posts as $post){
            if($post->status == 'publish'){
                // procura se tem imagem destacada ou no corpo como anexo
                $linkMedia = ($post->featured_media) ? $post->_links->{"wp:featuredmedia"}[0]->href : $post->_links->{"wp:attachment"}[0]->href;
                // objeto do post
                $date = date_create($post->date);
                $data_publicacao = ($date) ? date_format($date, 'd/m/y H:m:s') : date('d/m/y H:m:s');
                
                $data->{$count} = (object)[
                    'id' => $post->id,
                    'created_at' => $data_publicacao,
                    'title' => $post->title->rendered,
                    'exerpt'=> $post->excerpt->rendered,
                    'link' => $post->link,
                    'author' => $post->_embedded->author[0]->name,
                    'img' => $this->getFeaturedMedia($post->featured_media, $linkMedia )
                ];
                
            }  
             
            $count++;
        }
        return $data;
    }

    // Extrai imagem de destaque ou busca dentro das imagens dentro do post
    private function getFeaturedMedia( $isFeaturedMedia , $linkMedia )
    {
        $media = $this->getData($linkMedia);
        
        switch(true){
            case ($isFeaturedMedia) :
                return $media->media_details->sizes->medium->source_url;
                break;
            case (count($media)) :  
                return $media[0]->media_details->sizes->{"featured-blog-medium"}->source_url;
                break;
            default: 
                return "/assets/img/img-fundo-padrao.svg";     
        }
        
    }
    // Extrai o arquivo json e transforma em objeto de PHP
    private function getData($url){
        $request = file_get_contents($url);
        $data = json_decode($request, false);
        return $data;
    }
}    