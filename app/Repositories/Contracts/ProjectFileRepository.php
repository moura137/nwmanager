<?php

namespace NwManager\Repositories\Contracts;

/**
 * Interface ProjectFileRepository
 *
 * @package NwManager\Repositories\Contracts;
 */
interface ProjectFileRepository extends AbstractRepository
{
    /**
     * IsUser
     *
     * @param int $fileId
     * @param int $userId
     *
     * @return boolean
     */
    public function isUser($fileId, $userId);
}
