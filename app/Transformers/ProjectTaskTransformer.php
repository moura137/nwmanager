<?php

namespace NwManager\Transformers;

use NwManager\Entities\ProjectTask;

/**
 * Class ProjectTaskTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectTaskTransformer extends AbstractTransformer
{
    protected $defaultIncludes = [
        'project',
    ];

    /**
     * Transform the ProjectTask entity
     *
     * @param ProjectTask $task
     *
     * @return array
     */
    public function transform(ProjectTask $task)
    {
        return [
            'id'            => (int) $task->id,
            'name'          => $task->name,
            'start_date'    => $this->formatDate($task->start_date, 'Y-m-d'),
            'due_date'      => $this->formatDate($task->due_date, 'Y-m-d'),
            'final_date'    => $this->formatDate($task->final_date, 'Y-m-d H:i:s'),
            'status'        => $task->status,
            'created_at'    => $this->formatDate($task->created_at, 'Y-m-d H:i:s'),
            'updated_at'    => $this->formatDate($task->updated_at, 'Y-m-d H:i:s'),
            'project_id'    => $task->project_id,
            'project'       => $task->project,
        ];
    }

    /**
     * Include Project
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeProject(ProjectTask $task)
    {
        return $this->item($task->project, new ProjectTransformer(true), true);
    }
}