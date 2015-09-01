<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectFileRepository;
use NwManager\Entities\ProjectFile;
use NwManager\Presenters\ProjectFilePresenter;

/**
 * Class ProjectFileEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectFileEloquentRepository extends AbstractEloquentRepository implements ProjectFileRepository
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
        return ProjectFile::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ProjectFilePresenter::class;
    }

    /**
     * IsUser
     *
     * @param int $fileId
     * @param int $userId
     *
     * @return boolean
     */
    public function isUser($fileId, $userId)
    {
        return $this->find($fileId)->isUser($userId);
    }
}