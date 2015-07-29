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
        ValidatorInterface::RULE_CREATE => [
            'project_id'    => 'required|exists:project_notes,id',
            'title'         => 'required|max:255',
            'note'          => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'project_id'    => 'exists:project_notes,id',
            'title'         => 'max:255',
        ],
    ];
}