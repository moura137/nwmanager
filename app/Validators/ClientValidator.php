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
        ValidatorInterface::RULE_CREATE => [
            'name'          => 'required|max:255',
            'responsible'   => 'required|max:255',
            'email'         => 'required|max:255|email',
            'phone'         => 'required|max:255',
            'address'       => 'required|max:255',
            'obs'           => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'          => 'max:255',
            'responsible'   => 'max:255',
            'email'         => 'max:255|email',
            'phone'         => 'max:255',
            'address'       => 'max:255',
        ],
   ];
}