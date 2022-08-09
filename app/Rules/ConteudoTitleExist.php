<?php

namespace App\Rules;

use App\Models\Conteudo;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class ConteudoTitleExist implements Rule
{
    protected $title;

    private $err;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $response = true;
        $count = Conteudo::where('title', 'ilike', "%$value%")->count();
        $this->err = $value;
        if (request()->method() != 'PUT' && $count > 0) {
            $response = false;
        }

        return $response;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        $encode = urlencode($this->err);
        $url = "/recursos-educacionais/listar?busca={$encode}";
        $short_word = Str::words($this->err, 7);

        return "O título já existe <a target='_blank' href='{$url}'>{$short_word}</a>";
    }
}
