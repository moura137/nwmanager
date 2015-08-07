<?php

namespace NwManager\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;

/**
 * Class ProjectFileValidator
 *
 * @package NwManager\Validators;
 */
class ProjectFileValidator extends AbstractValidator
{
    protected $rules = [
        'project_id'    => 'required|exists:projects,id',
        'user_id'       => 'required|exists:users,id',
        'file'          => 'required|max:2048|mimes:jpeg,gif,png,jpg',
        'description'   => 'required|max:255',
    ];
}