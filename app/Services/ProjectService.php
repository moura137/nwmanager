<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Validators\ProjectValidator;
use Illuminate\Contracts\Auth\Guard;
use \Exception;

/**
 * Class ProjectService
 *
 * @package NwManager\Services;
 */
class ProjectService extends AbstractService
{   
    /**
     * The guard instance.
     *
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $auth;

    /**
     * Construct
     *
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Guard $auth)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->auth = $auth;
    }

    /**
     * Create
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data)
    {
        $project = parent::create($data);
        if ($project) {
            $this->addMember($project->id, $project->owner_id);
            $this->addMember($project->id, $this->auth->id());
        }

        return $project;
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
        $members = (array) $members;
        $project = $this->repository->find($id_project);

        try {
            if (count($members)) {
                $project->members()->attach($members);
            }
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
        
        $members = (array) $members;
        if (($index = array_search($project->owner_id, $members)) !== false){
            unset($members[$index]);
        }

        try {
            if (count($members)) {
                $project->members()->detach($members);
            }
            return true;

        } catch (\Exception $e) {
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

        $members = (array) $members;
        if (($index = array_search($project->owner_id, $members)) === false){
            array_push($members, $project->owner_id);
        }

        try {
            $project->members()->sync($members);
            return true;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }
}