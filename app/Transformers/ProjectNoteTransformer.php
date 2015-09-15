<?php

namespace NwManager\Transformers;

use NwManager\Entities\ProjectNote;

/**
 * Class ProjectNoteTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectNoteTransformer extends AbstractTransformer
{
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform the ProjectNote entity
     *
     * @param ProjectNote $note
     *
     * @return array
     */
    public function transform(ProjectNote $note)
    {
        return [
            'id'            => (int) $note->id,
            'project_id'    => $note->project_id,
            'title'         => $note->title,
            'note'          => $note->note,
            'created_at'    => $this->formatDate($note->created_at, 'Y-m-d H:i:s'),
            'updated_at'    => $this->formatDate($note->updated_at, 'Y-m-d H:i:s'),
            'diff_humans'   => diffForHumans($note->updated_at),
            'user_id'       => $note->user_id,
            'user'          => $note->user,
        ];
    }

    /**
     * Include User
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeUser(ProjectNote $note)
    {
        return $this->item($note->user, new UserTransformer(true), true);
    }
}