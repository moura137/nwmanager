<?php

namespace NwManager\Repositories\Contracts;

/**
 * Interface ProjectNoteRepository
 *
 * @package NwManager\Repositories\Contracts;
 */
interface ProjectNoteRepository extends AbstractRepository
{
    /**
     * IsUser
     *
     * @param int $noteId
     * @param int $userId
     *
     * @return boolean
     */
    public function isUser($noteId, $userId);
}
