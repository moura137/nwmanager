<?php

namespace NwManager\Transformers;

use League\Fractal\TransformerAbstract;
use NwManager\Entities\Project;

/**
 * Class ProjectTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectTransformer extends TransformerAbstract
{
    /**
     * Transform the Project entity
     *
     * @param Project $model
     *
     * @return array
     */
    public function transform(Project $model) {
        return [
            'project_id'   => (int) $model->id,
            'project'      => $model->name,
            'description'  => $model->description,
            'progress'     => $model->progress,
            'status'       => $model->status,
            'due_date'     => $model->due_date->format('Y-m-d'),
            // 'created_at'   => $model->created_at,
            // 'updated_at'   => $model->updated_at
        ];
    }
}