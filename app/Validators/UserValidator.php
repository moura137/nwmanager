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
            'username'  => 'required|min:4|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_\.]+[a-zA-Z0-9]$/|unique:users,username',
            'email'     => 'max:255|email|unique:users,email',
            'password'  => 'required|alpha_num|min:6|max:12|confirmed',
            'password_confirmation' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name'      => 'min:4|max:50',
            'username'  => 'min:4|max:30|regex:/^[a-zA-Z][a-zA-Z0-9_\.]+[a-zA-Z0-9]$/|unique:users,username',
            'email'     => 'max:255|email|unique:users,email',
            'password'  => 'alpha_num|min:6|max:12|confirmed',
        ],
   ];
}