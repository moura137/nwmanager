<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ActivityRepository;
use NwManager\Entities\Activity;
use NwManager\Presenters\ActivityPresenter;

/**
 * Class ActivityEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ActivityEloquentRepository extends AbstractEloquentRepository implements ActivityRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_name' => 'like',
        'project_name' => 'like',
        'event' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Activity::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ActivityPresenter::class;
    }
}