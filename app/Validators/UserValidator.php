<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class UserValidator
 *
 * @package NwManager\Validators;
 */
class UserValidator extends AbstractValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name'      => 'required|min:4|max:50',
            'email'     => 'required|max:255|email|unique:users,email',
            'password'  => 'required|alpha_num|min:6|max:12|confirmed',
            'password_confirmation' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'      => 'min:4|max:50',
            'email'     => 'max:255|email|unique:users,email',
            'password'  => 'alpha_num|min:6|max:12|confirmed',
            'password_confirmation' => 'required_with:password',
        ],
   ];
}