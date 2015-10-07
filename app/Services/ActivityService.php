<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ActivityRepository;
use NwManager\Validators\ActivityValidator;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use NwManager\Entities;
use NwManager\Events\ActivityEvent;

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

    public function createActivity($event, $entity = null)
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
            app('log')->error($e->getMessage());
            return false;
        }
    }

    protected function makeData($event, $user, $entity)
    {
        $data = [
            'user_id'      => $user->id,
            'user_name'    => $user->name,
            'project_id'   => null,
            'project_name' => null,
            'entity_id'    => null,
            'entity_type'  => null,
            'entity_desc'  => null,
            'event'        => $event,
        ];

        switch (true) {
            case $entity instanceof Entities\User:
                $data['entity_desc'] = 'Usuário ' . $entity->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                break;

            case $entity instanceof Entities\Client:
                $data['entity_desc'] = 'Cliente ' . $entity->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                break;

            case $entity instanceof Entities\Project:
                $data['entity_desc'] = 'Projeto ' . $entity->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->id;
                $data['project_id'] = $entity->name;
                break;

            case $entity instanceof Entities\ProjectFile:
                $data['entity_desc'] = 'Arquivo ' . $entity->file . ' no projeto ' . $entity->project->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->id;
                $data['project_id'] = $entity->project->name;
                break;

            case $entity instanceof Entities\ProjectNote:
                $data['entity_desc'] = 'Nota ' . $entity->title . ' no projeto ' . $entity->project->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->id;
                $data['project_id'] = $entity->project->name;
                break;

            case $entity instanceof Entities\ProjectTask:
                $data['entity_desc'] = 'Task ' . $entity->name . ' no projeto ' . $entity->project->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->id;
                $data['project_id'] = $entity->project->name;
                break;

            case $entity instanceof Entities\ProjectMember:
                $data['entity_desc'] = 'Membro ' . $entity->user->name . ' no projeto ' . $entity->project->name;
                $data['entity_id']   = $entity->getKey();
                $data['entity_type'] = get_class($entity);
                $data['project_id'] = $entity->project->id;
                $data['project_id'] = $entity->project->name;
                break;
        }

        return $data;
    }
}