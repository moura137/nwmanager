<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectNoteRepository;
use NwManager\Entities\ProjectNote;

/**
 * Class ProjectNoteEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectNoteEloquentRepository extends AbstractEloquentRepository implements ProjectNoteRepository
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
        return ProjectNote::class;
    }
}