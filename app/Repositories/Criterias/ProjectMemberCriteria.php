<?php

namespace NwManager\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * Class ProjectMemberCriteria
 *
 * @package Prettus\Repository\Criteria
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
            $userId = Authorizer::getResourceOwnerId();
            $query->orWhere('projects.owner_id', $userId);
            $query->orWhere('project_members.user_id', $userId);
            return $query;
        });

        return $query;
    }
}