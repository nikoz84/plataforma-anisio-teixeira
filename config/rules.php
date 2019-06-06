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
    "aplicativo" => [
        'name' => 'required|min:2|max:255',
        'description' => 'required|min:140',
        'url' => ['required', new \App\Rules\ValidUrl],
        'category_id' => 'required',
        'tags' => 'required',
        'image' => 'required',
        'is_featured' => 'required',
    ],
    "license" => [
        'parent_id' => 'nullable',
        'name' => 'required',
        'description' => 'required',
        'site' => ['nullable', new \App\Rules\ValidUrl],
    ],
    'register' => [
        'name' => 'required|string|max:255|min:4',
        'email' => 'required|string|max:100|unique:users,email',
        'password' => 'required|string|min:6|required_with:confirmation|same:confirmation',
        'confirmation' => 'required'
    ],
    'login' => [
        'email' => 'required|string|max:150',
        'password' => 'required|min:6',
    ],
    'denuncia' => [
        'name' => 'required|min:5',
        'email' => 'required',
        'url' => 'required',
        'subject' => 'required',
        'message' => 'required|min:30|max:170',
        'recaptcha' => ['required', new \App\Rules\ValidRecaptcha],
    ]
];
