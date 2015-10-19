<?php

namespace NwManager\Repositories\Eloquent;

use NwManager\Repositories\Contracts\ProjectRepository;
use NwManager\Entities\Project;
use NwManager\Presenters\ProjectPresenter;

/**
 * Class ProjectEloquentRepository
 *
 * @package NwManager\Repositories\Eloquent;
 */
class ProjectEloquentRepository extends AbstractEloquentRepository implements ProjectRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        $presenter = $this->makePresenter();

        Project::created(function($project) use($presenter) {
            $project->setPresenter($presenter);
            activity('Criado Novo Projeto', $project);
        });

        Project::updated(function($project) use($presenter) {
            $project->setPresenter($presenter);
            activity('Alterado Projeto', $project);
        });

        Project::deleted(function($project) use($presenter) {
            $project->setPresenter($presenter);
            activity('Excluído Projeto', $project);
        });
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ProjectPresenter::class;
    }

    /**
     * IsOwner
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function isOwner($projectId, $userId)
    {
        return $this->find($projectId)->isOwner($userId);
    }

    /**
     * Has Member
     *
     * @param int $projectId
     * @param int $userId
     *
     * @return boolean
     */
    public function hasMember($projectId, $userId)
    {
        return (bool) ($this->find($projectId)->hasMember($userId));
    }

    /**
     * Members
     *
     * @param int $projectId
     *
     * @return Collection
     */
    public function members($projectId)
    {
        return $this->find($projectId)
            ->members()
            ->orderBy('name', 'ASC')
            ->get();
    }
}