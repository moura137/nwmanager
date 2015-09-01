<?php

namespace NwManager\Repositories\Contracts;

/**
 * Interface ProjectRepository
 *
 * @package NwManager\Repositories\Contracts;
 */
interface ProjectRepository extends AbstractRepository
{
    /**
     * IsOwner
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function isOwner($projectId, $userId);

    /**
     * Has Member
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function hasMember($projectId, $userId);
}
