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
        'project_id'    => 'required|exists:projects,id',
        'name'          => 'required|max:255',
        'status'        => 'required|in:0,1',
        'start_date'    => 'date',
        'due_date'      => 'date',
    ];
}