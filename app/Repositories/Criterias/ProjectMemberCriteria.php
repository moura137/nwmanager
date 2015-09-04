<?php

namespace NwManager\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use Illuminate\Support\Facades\Auth;

/**
 * Class ProjectMemberCriteria
 *
 * @package NwManager\Repositories\Criterias
 */
class ProjectMemberCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param Builder $query
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($query, RepositoryInterface $repository)
    {
        $query->leftJoin('project_members', 'projects.id', '=', 'project_members.project_id');
        $query->select('projects.*');
        $query->groupBy('projects.id');

        $query->where(function($query) {
            $userId = Auth::id();
            $query->orWhere('projects.owner_id', $userId);
            $query->orWhere('project_members.user_id', $userId);
            return $query;
        });

        return $query;
    }
}