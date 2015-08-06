<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Entities\ProjectTask;
use NwManager\Presenters\ProjectTaskPresenter;

/**
 * Class ProjectTaskEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectTaskEloquentRepository extends AbstractEloquentRepository implements ProjectTaskRepository
{
    /**
     * @var array
     */
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

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ProjectTaskPresenter::class;
    }
}