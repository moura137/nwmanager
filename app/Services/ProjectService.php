<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Validators\ProjectValidator;

/**
 * Class ProjectService
 *
 * @package NwManager\Services;
 */
class ProjectService extends AbstractService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;
    
    /**
     * Construct
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}