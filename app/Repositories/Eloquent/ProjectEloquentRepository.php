<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Entities\Project;

/**
 * Class ProjectEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectEloquentRepository extends AbstractEloquentRepository implements ProjectRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * IsOwner
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function isOwner($projectId, $userId)
    {
        return $this->find($projectId)->isOwner($userId);
    }

    /**
     * Has Member
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function hasMember($projectId, $userId)
    {
        return (bool) ($this->find($projectId)->hasMember($userId));
    }
}