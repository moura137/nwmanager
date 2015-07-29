<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ProjectTaskValidator
 *
 * @package NwManager\Validators;
 */
class ProjectTaskValidator extends AbstractValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'project_id'    => 'required|exists:projects,id',
            'name'          => 'required|max:255',
            'start_date'    => 'required|date|date_format:d/m/Y',
            'due_date'      => 'required|date|date_format:d/m/Y',
            'status'        => 'required|in:1,2,3',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'project_id'    => 'exists:projects,id',
            'name'          => 'max:255',
            'start_date'    => 'date|date_format:d/m/Y',
            'due_date'      => 'date|date_format:d/m/Y',
            'status'        => 'in:1,2,3',
        ],
    ];
}