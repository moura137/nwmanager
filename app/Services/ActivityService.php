<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ActivityRepository;
use NwManager\Validators\ActivityValidator;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use NwManager\Events\ActivityEvent;
use NwManager\Entities;

/**
 * Class ActivityService
 *
 * @package NwManager\Services;
 */
class ActivityService
{
    protected $auth;

    protected $repository;

    protected $validator;

    /**
     * Construct
     *
     * @param ActivityRepository $repository
     */
    public function __construct(Guard $auth, ActivityRepository $repository, ActivityValidator $validator)
    {
        $this->auth = $auth;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Create Activity
     *
     * @param string         $event
     * @param AbstractEntity $entity
     *
     * @return Activity
     */
    public function createActivity($event, Entities\AbstractEntity $entity = null)
    {
        try {
            $user = $this->auth->user();

            $data = $this->makeData($event, $user, $entity);

            $activity = $this->repository->create($data);

            if ($activity) {
                event(new ActivityEvent($activity));
            }

            return $activity;

        } catch (Exception $e) {
            app('log')->error(sprintf("%s, %s in %s:(%s)", $e->getMessage(), get_class($e), $e->getFile(), $e->getLine()));
        }

        return false;
    }

    protected function makeData($event, Entities\User $user = null, Entities\AbstractEntity $entity = null)
    {
        $user_id = $user ? $user->getKey() : null;
        $user_name = $user ? $user->getName() : null;

        $data = [
            'user_id'      => $user_id,
            'user_name'    => $user_name,
            'project_id'   => null,
            'project_name' => null,
            'entity_id'    => null,
            'entity_type'  => null,
            'entity_desc'  => null,
            'event'        => $event,
        ];

        switch (true) {
            case $entity instanceof Entities\User:
                $data['entity_desc'] = 'Usuário ' . $entity->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                break;

            case $entity instanceof Entities\Client:
                $data['entity_desc'] = 'Cliente ' . $entity->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                break;

            case $entity instanceof Entities\Project:
                $data['entity_desc'] = 'Projeto ' . $entity->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->getKey();
                $data['project_id'] = $entity->getName();
                break;

            case $entity instanceof Entities\ProjectFile:
                $data['entity_desc'] = 'Arquivo ' . $entity->file . ' no projeto ' . $entity->project->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->getKey();
                $data['project_name'] = $entity->project->getName();
                break;

            case $entity instanceof Entities\ProjectNote:
                $data['entity_desc'] = 'Nota ' . $entity->title . ' no projeto ' . $entity->project->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->getKey();
                $data['project_name'] = $entity->project->getName();
                break;

            case $entity instanceof Entities\ProjectTask:
                $data['entity_desc'] = 'Task ' . $entity->getName() . ' no projeto ' . $entity->project->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->getKey();
                $data['project_name'] = $entity->project->getName();
                break;

            case $entity instanceof Entities\ProjectMember:
                $data['entity_desc'] = 'Membro ' . $entity->getName() . ' no projeto ' . $entity->project->getName();
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->getKey();
                $data['project_name'] = $entity->project->getName();
                break;
        }

        return $data;
    }
}