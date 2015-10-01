<?php

namespace NwManager\Transformers;

use NwManager\Entities\Project;

/**
 * Class ProjectTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectTransformer extends AbstractTransformer
{
    /**
     * @var [type]
     */
    protected $defaultIncludes = [
        'owner',
        'client',
        'members',
    ];

    /**
     * Transform the Project entity
     *
     * @param Project $project
     *
     * @return array
     */
    public function transform(Project $project)
    {
        $return = [
            'id'            => (int) $project->id,
            'name'          => $project->name,
            'description'   => $project->description,
            'progress'      => $project->progress,
            'status'        => $project->status,
            'due_date'      => $this->formatDate($project->due_date, 'Y-m-d'),
            'owner_id'      => $project->owner_id,
            'owner'         => $project->owner,
            'client_id'     => $project->client_id,
            'client'        => $project->client,
            'members'       => $project->members,
        ];

        if (!$this->includeData) {
            $return['created_at'] = $this->formatDate($project->created_at, 'Y-m-d H:i:s');
            $return['updated_at'] = $this->formatDate($project->updated_at, 'Y-m-d H:i:s');
        }

        return $return;
    }

    /**
     * Include Members
     *
     * @return League\Fractal\Resource\Collection
     */
    public function includeMembers(Project $project)
    {
        return $this->collection($project->members, new ProjectMemberTransformer(true), true);
    }

    /**
     * Include Owner
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeOwner(Project $project)
    {
        return $this->item($project->owner, new UserTransformer(true), true);
    }

    /**
     * Include Client
     *
     * @return League\Fractal\Resource\Item
     */
    public function includeClient(Project $project)
    {
        return $this->item($project->client, new ClientTransformer(true), true);
    }
}