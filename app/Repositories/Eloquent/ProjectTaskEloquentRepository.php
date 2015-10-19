<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Entities\ProjectTask;
use NwManager\Presenters\ProjectTaskPresenter;
use NwManager\Events\NewTaskEvent;
use NwManager\Events\EditTaskEvent;

/**
 * Class ProjectTaskEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectTaskEloquentRepository extends AbstractEloquentRepository implements ProjectTaskRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'title' => 'like',
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $presenter = $this->makePresenter();

        ProjectTask::created(function($task) use($presenter) {
            $task->setPresenter($presenter);

            activity('Criada Nova Tarefa', $task);
            event(new NewTaskEvent($task));
        });

        ProjectTask::updated(function($task) use($presenter) {
            $task->setPresenter($presenter);

            if ($task->status == '1') {
                activity('Finalizada Tarefa', $task);
            } else {
                activity('Alterada Tarefa', $task);
            }

            event(new EditTaskEvent($task));
        });
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectTask::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ProjectTaskPresenter::class;
    }
}