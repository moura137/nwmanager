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
        'start_date'    => 'required|date|date_format:d/m/Y',
        'due_date'      => 'required|date|date_format:d/m/Y',
        'status'        => 'required|in:1,2,3',
    ];
}