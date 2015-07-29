<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Entities\ProjectTask;

/**
 * Class ProjectTaskEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectTaskEloquentRepository extends AbstractEloquentRepository implements ProjectTaskRepository
{
    protected $fieldSearchable = [
        'title' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }
}