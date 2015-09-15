<?php

namespace NwManager\Transformers;

use NwManager\Entities\ProjectFile;

/**
 * Class ProjectFileTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectFileTransformer extends AbstractTransformer
{
    protected $defaultIncludes = [
        'user',
        // 'project',
    ];

    /**
     * Transform the ProjectFile entity
     *
     * @param ProjectFile $file
     *
     * @return array
     */
    public function transform(ProjectFile $file)
    {
        return [
            'id'            => (int) $file->id,
            'project_id'    => $file->project_id,
            'description'   => $file->description,
            'file'          => $file->file,
            'extension'     => $file->extension,
            'size'          => $file->size,
            'created_at'    => $this->formatDate($file->created_at, 'Y-m-d H:i:s'),
            'updated_at'    => $this->formatDate($file->updated_at, 'Y-m-d H:i:s'),
            'user_id'       => $file->user_id,
            'user'          => $file->user,
            // 'project'       => $file->project,
        ];
    }

    /**
     * Include User
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeUser(ProjectFile $file)
    {
        return $this->item($file->user, new UserTransformer(true), true);
    }

    /**
     * Include Project
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeProject(ProjectFile $file)
    {
        return $this->item($file->project, new ProjectTransformer(true), true);
    }
}