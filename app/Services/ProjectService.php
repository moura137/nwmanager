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
     * @param int|array $members
     *
     * @return bool
     */
    public function addMember($id_project, $members)
    {
        $project = $this->repository->find($id_project);

        try {
            $project->members()->attach((array) $members);
            return true;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Remove Member
     *
     * @param int       $id_project
     * @param int|array $members
     *
     * @return int
     */
    public function removeMember($id_project, $members)
    {
        $project = $this->repository->find($id_project);

        try {
            $project->members()->detach((array) $members);
            return true;

        } catch (\Exception $e) {
            dd($e);
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Sync Member
     *
     * @param int       $id_project
     * @param int|array $members
     *
     * @return array
     */
    public function syncMember($id_project, $members)
    {
        $project = $this->repository->find($id_project);

        try {
            $project->members()->sync((array) $members);
            return true;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }
}