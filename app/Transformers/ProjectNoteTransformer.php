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
        'project',
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
            'title'         => $note->title,
            'note'          => $note->note,
            'created_at'    => $this->formatDate($note->created_at, 'Y-m-d H:i:s'),
            'updated_at'    => $this->formatDate($note->updated_at, 'Y-m-d H:i:s'),
            'user_id'       => $note->user_id,
            'user'          => $note->user,
            'project_id'    => $note->project_id,
            'project'       => $note->project,
        ];
    }

    /**
     * Include User
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeUser(ProjectNote $note)
    {
        return $this->item($note->user, new UserTransformer);
    }

    /**
     * Include Project
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeProject(ProjectNote $note)
    {
        return $this->item($note->project, new ProjectTransformer(false));
    }
}