<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */
    'accepted' => ':Attribute deve ser aceito.',
    'active_url' => ':Attribute não é uma URL válida.',
    'after' => ':Attribute deve ser uma data depois de :date.',
    'after_or_equal' => ':Attribute deve ser uma data posterior ou igual à :date.',
    'alpha' => ':Attribute deve conter somente letras.',
    'alpha_dash' => ':Attribute deve conter letras, números e traços.',
    'alpha_num' => ':Attribute deve conter somente letras e números.',
    'array' => ':Attribute deve ser um array.',
    'before' => ':Attribute deve ser uma data antes de :date.',
    'before_or_equal' => ':Attribute deve ser uma data anterior ou igual à :date.',
    'between' => [
        'numeric' => ':Attribute deve estar entre :min e :max.',
        'file' => ':Attribute deve estar entre :min e :max kilobytes.',
        'string' => ':Attribute deve estar entre :min e :max caracteres.',
        'array' => ':Attribute deve ter entre :min e :max itens.',
    ],
    'boolean' => ':Attribute deve ser verdadeiro ou falso.',
    'confirmed' => 'A confirmação de :attribute não confere.',
    'date' => ':Attribute não é uma data válida.',
    'date_format' => ':Attribute não confere com o formato :format.',
    'different' => ':Attribute e :other devem ser diferentes.',
    'digits' => ':Attribute deve ter :digits dígitos.',
    'digits_between' => ':Attribute deve ter entre :min e :max dígitos.',
    'dimensions' => ':Attribute tem dimensões de imagem inválidas.',
    'distinct' => ':Attribute tem um valor duplicado.',
    'email' => ':Attribute deve ser um endereço de e-mail válido.',
    'exists' => 'O :attribute selecionado é inválido.',
    'file' => ':Attribute deve ser um arquivo.',
    'filled' => ':Attribute é um campo obrigatório.',
    'image' => ':Attribute deve ser uma imagem.',
    'in' => ':Attribute é inválido.',
    'in_array' => ':Attribute não existe em :other.',
    'integer' => ':Attribute deve ser um inteiro.',
    'ip' => ':Attribute deve ser um endereço IP válido.',
    'ipv4' => ':Attribute deve ser um endereço IPv4 válido.',
    'ipv6' => ':Attribute deve ser um endereço IPv6 válido.',
    'json' => ':Attribute deve ser um JSON válido.',
    'max' => [
        'numeric' => ':Attribute não deve ser maior que :max.',
        'file' => ':Attribute não deve ter mais que :max kilobytes.',
        'string' => ':Attribute não deve ter mais que :max caracteres.',
        'array' => ':Attribute não deve ter mais que :max itens.',
    ],
    'mimes' => ':Attribute deve ser um arquivo do tipo: :values.',
    'mimetypes' => ':Attribute deve ser um arquivo do tipo: :values.',
    'min' => [
        'numeric' => ':Attribute deve ser no mínimo :min.',
        'file' => ':Attribute deve ter no mínimo :min kilobytes.',
        'string' => ':Attribute deve ter no mínimo :min caracteres.',
        'array' => ':Attribute deve ter no mínimo :min itens.',
    ],
    'not_in' => 'O :attribute selecionado é inválido.',
    'numeric' => ':Attribute deve ser um número.',
    'present' => 'O :attribute deve estar presente.',
    'regex' => 'O formato de :attribute é inválido.',
    'required' => 'Campo :attribute é obrigatório.',
    'required_if' => 'O campo :attribute é obrigatório quando :other é :value.',
    'required_unless' => 'O :attribute é necessário a menos que :other esteja em :values.',
    'required_with' => 'O campo :attribute é obrigatório quando :values está presente.',
    'required_with_all' => 'O campo :attribute é obrigatório quando :values estão presentes.',
    'required_without' => 'O campo :attribute é obrigatório quando :values não está presente.',
    'required_without_all' => 'O campo :attribute é obrigatório quando nenhum destes estão presentes: :values.',
    'same' => ':Attribute e :other devem ser iguais.',
    'size' => [
        'numeric' => ':Attribute deve ser :size.',
        'file' => ':Attribute deve ter :size kilobytes.',
        'string' => ':Attribute deve ter :size caracteres.',
        'array' => ':Attribute deve conter :size itens.',
    ],
    'string' => ':Attribute deve ser uma string',
    'timezone' => ':Attribute deve ser uma timezone válida.',
    'unique' => ':Attribute já está em uso.',
    'uploaded' => 'O :attribute falhou ao ser enviado.',
    'url' => 'O formato de :attribute é inválido.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */
    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */
    'attributes' => [
        'title' => 'título',
        'description' => 'descrição',
        'name' => 'nome',
        'message' => 'mensagem',
        'options' => 'opções',
        'email' => 'e-mail',
        'source' => 'fonte',
        'authors' => 'autores',
        'tipo_id' => 'tipo',
        'license_id' => 'licença',
        'canal_id' => 'canal',
        'is_approved' => 'aprovar conteúdo',
        'is_site' => 'site',
        'is_featured' => 'destaque',
        'terms' => 'termos e condições',
        'image' => 'arquivo de imagem',
        'options_is_featured' => 'destaque',
        'options_site' => 'site',
        'video' => 'vídeo',
        'file' => 'arquivo',
        'role' => 'tipo',
        'url' => 'url',
        'tags' => 'palabras chaves',
        'category' => 'categoria',
        'category_id' => 'categoria',
        'recaptcha' => 'código de segurança',
        'subject' => 'assunto',
        'password' => 'senha',
        'confirmation' => 'confirmação da senha',
        'birthday' => 'nascimento',
        'delete_confirmation' => 'confirmação',
        'download' => 'arquivo de download',
        'componentes' => 'componentes curriculares',
        'options.description' => 'descrição',
        'options.is_active' => 'marcar como ativo',
        'options.is_featured' => 'marcar como destaque',
    ],
    'options' => [
        'lang' => 'pt_BR',
    ],
];
