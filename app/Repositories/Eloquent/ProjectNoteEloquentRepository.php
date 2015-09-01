<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Entities\ProjectNote;
use NwManager\Presenters\ProjectNotePresenter;

/**
 * Class ProjectNoteEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectNoteEloquentRepository extends AbstractEloquentRepository implements ProjectNoteRepository
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
        return ProjectNote::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ProjectNotePresenter::class;
    }

    /**
     * IsUser
     *
     * @param int $noteId
     * @param int $userId
     *
     * @return boolean
     */
    public function isUser($noteId, $userId)
    {
        return $this->find($noteId)->isUser($userId);
    }
}