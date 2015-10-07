<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ActivityValidator
 *
 * @package NwManager\Validators;
 */
class ActivityValidator extends AbstractValidator
{
    protected $rules = [
        'user_id'       => 'required|exists:users,id',
        'user_name'     => 'required|max:255',
        'event'         => 'required|max:255',
        'entity_desc'   => 'max:255',
    ];
}