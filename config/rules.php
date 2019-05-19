<?php

return [
    "conteudo" => [
        'license_id' => 'required',
        'canal_id' => 'required',
        'category_id' => 'nullable',
        'title' => 'required|min:10|max:255',
        'description' => 'required|min:140',
        'tipo_id' => 'required',
        'site' => 'nullable',
        'guia' => 'nullable',
        'download' => 'nullable',
        'visualizacao' => 'nullable',
        'tags' => 'required',
        'componentes' => 'required',
        'authors' => 'required',
        'source' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'terms' => 'required|in:true,false',
        'is_featured' => 'nullable|in:true,false',
        'is_approved' => 'required|in:true,false',
        'is_site' => 'nullable|in:true,false'
    ],
    "license" => [
        'parent_id' => 'nullable',
        'name' => 'required',
        'description' => 'required',
        'site' => 'nullable',
    ],
    'register' => [
        'name' => 'required|string|max:255|min:4',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:6|required_with:password_confirmation|same:password_confirmation',
        'password_confirmation' => 'required'
    ],
    'login' => [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
    ]
];
