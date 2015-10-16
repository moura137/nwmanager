<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ClientValidator
 *
 * @package NwManager\Validators;
 */
class ClientValidator extends AbstractValidator
{
    protected $rules = [
        'name'          => 'required|max:255',
        'responsible'   => 'required|max:255',
        'email'         => 'required|max:255|email',
        'phone'         => 'required|max:255',
        'address'       => 'required|max:255',
        'site'          => 'max:255',
        'facebook'      => 'max:255',
        'twitter'       => 'max:255',
        'googleplus'    => 'max:255',
        'skype'         => 'max:255',
    ];
}