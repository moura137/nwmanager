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
        ValidatorInterface::RULE_CREATE => [
            'owner_id'      => 'required|exists:users,id',
            'client_id'     => 'required|exists:clients,id',
            'name'          => 'required|max:255',
            'progress'      => 'required|int|min:0|max:100',
            'status'        => 'required|in:1,2,3',
            'due_date'      => 'required|date',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'owner_id'      => 'exists:users,id',
            'client_id'     => 'exists:clients,id',
            'name'          => 'max:255',
            'progress'      => 'int|min:0|max:100',
            'status'        => 'in:1,2,3',
            'due_date'      => 'date|date_format:d/m/Y',
        ],
    ];
}