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
    /**
     * The database table used by the model.
     *
     * @var string
     */
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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'project_id',
		'user_id',
	];

    /**
     * Description Entity
     *
     * @return string
     */
    public function getName()
    {
        return $this->user->name;
    }

    /**
     * Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
