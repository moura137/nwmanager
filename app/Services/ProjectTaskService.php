<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Validators\ProjectTaskValidator;

/**
 * Class ProjectTaskService
 *
 * @package NwManager\Services;
 */
class ProjectTaskService extends AbstractService
{
    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;
    
    /**
     * Construct
     *
     * @param ProjectTaskRepository $repository
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
}