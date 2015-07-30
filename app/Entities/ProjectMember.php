<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;
use NwManager\Entities\User;

/**
 * Class ProjectMembers Entity
 *
 * @package NwManager\Entities;
 */
class ProjectMember extends AbstractEntity
{
    protected $tables = 'project_members';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
		'project_id',
		'user_id',
	];
}
