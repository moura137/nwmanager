<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Validators\ProjectValidator;
use \Exception;

/**
 * Class ProjectService
 *
 * @package NwManager\Services;
 */
class ProjectService extends AbstractService
{   
    /**
     * Construct
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Add Member
     *
     * @param int       $id_project
     * @param int|array $users
     *
     * @return bool
     */
    public function addMember($id_project, $users)
    {
        $project = $this->repository->find($id_project);

        $users = (array) $users;
        $project->members()->attach($users);

        return true;
    }

    /**
     * Remove Member
     *
     * @param int       $id_project
     * @param int|array $users
     *
     * @return int
     */
    public function removeMember($id_project, $users)
    {
        $project = $this->repository->find($id_project);

        $users = (array) $users;
        return $project->members()->detach($users);
    }

    /**
     * Is Member
     *
     * @param int       $id_project
     * @param int|array $users
     *
     * @return bool
     */
    public function isMember($id_project, $id_user)
    {
        $project = $this->repository->find($id_project);

        return (bool) $project->members()->find($id_user);
    }
}