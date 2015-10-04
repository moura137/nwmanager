<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used
    | by the validator class. Some of the rules contain multiple versions,
    | such as the size (max, min, between) rules. These versions are used
    | for different input types such as strings and files.
    |
    | These language lines may be easily changed to provide custom error
    | messages in your application. Error messages for custom validation
    | rules may also be added to this file.
    |
    */

    "accepted"       => "O :attribute tem que ser aceito.",
    "active_url"     => "O :attribute não é um URL válida.",
    "after"          => "A :attribute deve ser uma data depois de :date.",
    "alpha"          => "O :attribute deve conter apenas letras.",
    "alpha_dash"     => "O :attribute deve conter apenas letras, números e traços.",
    "alpha_num"      => "O :attribute deve conter apenas letras e números.",
    "array"          => "O :attribute deve ter elementos selecionados.",
    "before"         => "A :attribute deve ser uma data anterior a :date.",
    "between"        => array(
        "numeric" => "O :attribute deve estar entre :min e :max.",
        "file"    => "O :attribute deve estar entre :min e :max KB.",
        "string"  => "O :attribute deve estar entre :min e :max caracteres.",
        "array"   => "O :attribute deve estar entre :min e :max itens.",
    ),
    "boolean"        => "O :attribute deve ser verdadeiro ou falso.",
    "confirmed"      => "A Confirmação de :attribute não confere.",
    "count"          => "O :attribute deve ter exatamente :count elementos selecionados.",
    "countbetween"   => "O :attribute deve ter um valor mínimo de :min e máximo de :max campos selecionados.",
    "countmax"       => "O :attribute deve ter menos de :max campos selecionados.",
    "countmin"       => "O :attribute deve ter no mínimo :min campos selecionados.",
    "date"           => "O :attribute não é uma data valida.",
    "date_format"    => "o :attribute não coincide com o formato :format.",
    "different"      => "O :attribute e :other devem ser diferentes.",
    "digits"         => "O :attribute deve ter :digits dígitos.",
    "digits_between" => "O :attribute deve estar entre :min and :max dígitos.",
    "email"          => "O :attribute não é um formato de email válido.",
    "filled"         => "O :attribute é obrigatório.",
    "exists"         => "O :attribute selecionado não existe.",
    "image"          => "O :attribute deve ser uma imagem.",
    "in"             => "O :attribute selecionado não é válido.",
    "integer"        => "O :attribute deve ser um inteiro.",
    "ip"             => "O :attribute deve conter um IP válido.",
    "match"          => "O formato do :attribute não é válido.",
    "max"            => array(
        "numeric" => "O :attribute deve ser menor que :max.",
        "file"    => "O :attribute deve ser menor que :max KB.",
        "string"  => "O :attribute deve ter menos de :max caracteres.",
        "array"   => "O :attribute deve ter menos de :max itenss.",
    ),
    "mimes"          => "O :attribute deve ser do tipo: :values.",
    "min"            => array(
        "numeric" => "O :attribute deve ser maior que :min.",
        "file"    => "O :attribute deve ser maior que :min KB.",
        "string"  => "O :attribute deve ter mais de :min characters.",
        "array"   => "O :attribute deve ter mais de :min items.",
    ),
    "not_in"         => "O :attribute selecionado não é válido.",
    "numeric"        => "O :attribute deve ser um número.",
    "regex"          => "O :attribute esta com formato inválido.",
    "required"       => "O :attribute é obrigatório.",
    "required_if"          => "O :attribute é obrigatório quando :other for igual a :value.",
    "required_with"        => "O :attribute é obrigatório quando :values está presente.",
    "required_with_all"    => "O :attribute é obrigatório quando :values está presente.",
    "required_without"     => "O :attribute é obrigatório quando :values não está presente.",
    "required_without_all" => "O :attribute é obrigatório quando nenhum dos :values estão presentes",
    "same"           => "O :attribute e :other devem ser iguais.",
    "size"           => array(
        "numeric" => "O :attribute deve ter um tamanho de :size.",
        "file"    => "O :attribute deve ter :size kilobyte.",
        "string"  => "O :attribute deve ter :size caracteres.",
        "array"   => "O :attribute deve ter :size itens.",
    ),
    "unique"         => "O :attribute já está em uso.",
    "url"            => "O :attribute não é um formato de URL válida.",
    "timezone"       => "O :attribute deve ter uma zona válida.",

    // Custom Validation
    "current_password" => "A :attribute não confere.",
    "pregmatch" => "O campo :attribute não é uma expressão regular valida.",
    "cpf" => "O Cpf é inválido.",
    "cnpj" => "O Cnpj é inválido.",
    "upload" => array(
        "type" => "O arquivo deve ser uma imagem valida.",
        "size" => "A imagem deve ser menor que :limit Mb",
        'error' => 'Erro no ao tentar efetuar o upload',
    ),

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

    'custom' => array(),

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

    'attributes' => array(
    ),
);