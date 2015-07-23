<?php

namespace NwManager\Validators;

use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
    protected $rules = [
        'name'          => 'required|max:255',
        'responsible'   => 'required|max:255',
        'email'         => 'required|max:255|email',
        'phone'         => 'required|max:255',
        'address'       => 'required|max:255',
        'obs'           => 'required',
    ];
}