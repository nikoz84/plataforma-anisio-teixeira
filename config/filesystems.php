<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public'),
            'url' => env('APP_URL') . DIRECTORY_SEPARATOR . 'storage',
            'visibility' => 'public',
        ],
        'public-path' => [
            'driver' => 'local',
            'root' => public_path(),
            'url' => env('APP_URL') . DIRECTORY_SEPARATOR,
            'visibility' => 'public',
        ],
        'conteudos-blog' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-blog' . DIRECTORY_SEPARATOR . 'uploads'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-blog/uploads',
            'visibility' => 'public',
        ],

        'conteudos-digitais' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais',
            'visibility' => 'public',
        ],

        'aplicativos-educacionais' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'aplicativos-educacionais'),
            'url' => env('APP_URL') . '/storage/conteudos/aplicativos-educacionais/',
            'visibility' => 'public',
        ],

        'download' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'download'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/download',
            'visibility' => 'public',
        ],

        'fotos-perfil' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'fotos-perfil'),
            'url' => '/storage/conteudos/fotos-perfil',
            'visibility' => 'public',
        ],

        'visualizacao' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'visualizacao'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/visualizacao',
            'visibility' => 'public',
        ],

        'streaming' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'streaming'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/streaming',
            'visibility' => 'public',
        ],

        'podcast-at' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'podcast-at'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/podcast-at',
            'visibility' => 'public',
        ],

        'slider' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'slider'),
            'url' => env('APP_URL') . '/storage/conteudos/slider',
            'visibility' => 'public',
        ],

        'sinopse' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'imagem-associada' . DIRECTORY_SEPARATOR . 'sinopse'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/imagem-associada/sinopse',
            'visibility' => 'public',
        ],
        'galeria' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'galeria'),
            'url' => env('APP_URL') . '/storage/conteudos/galeria',
            'visibility' => 'public',
        ],

        'iat-docs' => [
            'driver' => 'local',
            'root' => storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'conteudos' . DIRECTORY_SEPARATOR . 'conteudos-digitais' . DIRECTORY_SEPARATOR . 'iat-docs'),
            'url' => env('APP_URL') . '/storage/conteudos/conteudos-digitais/iat-docs',
            'visibility' => 'public',

        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],
    'ftp' => [
        'driver' => 'ftp',
        'host' => env('DISK_FTP_HOST', ''),
        'port' => env('DISK_FTP_PORT', 21),
        'username' => env('DISK_FTP_USERNAME', ''),
        'password' => env('DISK_FTP_PASSWORD', ''),
        'root' => env('DISK_FTP_ROOT', ''),
    ],

];