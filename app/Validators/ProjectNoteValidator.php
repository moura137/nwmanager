<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ProjectNoteValidator
 *
 * @package NwManager\Validators;
 */
class ProjectNoteValidator extends AbstractValidator
{
    protected $rules = [
        'project_id'    => 'required|exists:projects,id',
        'user_id'       => 'required|exists:users,id',
        'title'         => 'required|max:255',
        'note'          => 'required',
    ];
}