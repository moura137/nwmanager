<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Validators\ProjectNoteValidator;

/**
 * Class ProjectNoteService
 *
 * @package NwManager\Services;
 */
class ProjectNoteService extends AbstractService
{
    /**
     * @var ProjectNoteRepository
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;
    
    /**
     * Construct
     *
     * @param ProjectNoteRepository $repository
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}