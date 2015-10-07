<?php

namespace NwManager\Transformers;

use NwManager\Entities\Activity;

/**
 * Class ActivityTransformer
 *
 * @package NwManager\Transformers;
 */
class ActivityTransformer extends AbstractTransformer
{
    protected $defaultIncludes = [];

    /**
     * Transform the Activity entity
     *
     * @param Activity $activity
     *
     * @return array
     */
    public function transform(Activity $activity)
    {
        return [
            'id'            => (int) $activity->id,
            'user_id'       => $activity->user_id,
            'user_name'     => $activity->user_name,
            'project_id'    => $activity->project_id,
            'project_name'  => $activity->project_name,
            'event'         => $activity->event,
            'entity_id'     => $activity->entity_id,
            'entity_type'   => $activity->entity_type,
            'entity_desc'   => $activity->entity_desc,
            'event'         => $activity->event,
            'created_at'    => $this->formatDate($activity->created_at, 'Y-m-d H:i:s'),
            'diff_humans'   => diffForHumans($activity->created_at),
        ];
    }
}