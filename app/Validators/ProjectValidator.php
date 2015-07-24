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
            'description'   => 'required|max:255',
            'progress'      => 'required|max:255',
            'status'        => 'required|in:A,I',
            'due_date'      => 'required|date',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'owner_id'      => 'exists:users,id',
            'client_id'     => 'exists:clients,id',
            'name'          => 'max:255',
            'description'   => 'max:255',
            'progress'      => 'max:255',
            'status'        => 'in:A,I',
            'due_date'      => 'date',
        ],
    ];
}