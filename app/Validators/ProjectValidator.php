<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ProjectValidator
 *
 * @package NwManager\Validators;
 */
class ProjectValidator extends AbstractValidator
{
    protected $rules = [
        'owner_id'      => 'required|exists:users,id',
        'client_id'     => 'required|exists:clients,id',
        'name'          => 'required|max:255',
        'progress'      => 'required|integer|min:0|max:100',
        'status'        => 'required|in:1,2,3',
        'due_date'      => 'required|date',
    ];
}