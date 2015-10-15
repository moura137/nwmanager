<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Validators\ProjectTaskValidator;
use NwManager\Repositories\Criterias\InputCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use NwManager\Entities\ProjectTask;
use NwManager\Events\NewTaskEvent;
use NwManager\Events\EditTaskEvent;

/**
 * Class ProjectTaskService
 *
 * @package NwManager\Services;
 */
class ProjectTaskService extends AbstractService
{
    /**
     * Construct
     *
     * @param ProjectTaskRepository $repository
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Finaliza a Tarefa Update
     *
     * @param Entity|int $id
     * @param array      $data
     *
     * @return Model
     */
    public function finishTask(ProjectTask $task)
    {
        try {
            if ($task->status == '1') {
                return true;
            }

            $task->final_date = date('Y-m-d H:i:s');
            $task->status = '1';
            $success = (bool) $task->save();

            if ($success) {
                event(new EditTaskEvent($task));
            }

            return $success;

        } catch (\Exception $e) {
            $task->setRawAttributes($task->getOriginal());
            return false;
        }
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
        $task = parent::create($data);

        if ($task) {
            event(new NewTaskEvent($task));
        }

        return $task;
    }

    /**
     * Update
     *
     * @param Entity|int $id
     * @param array      $data
     * @param array      $criterias
     *
     * @return Model
     */
    public function update($id, array $data = [], $criterias = [])
    {
        $task = parent::update($id, $data, $criterias);

        if ($task) {
            event(new EditTaskEvent($task));
        }

        return $task;
    }
}