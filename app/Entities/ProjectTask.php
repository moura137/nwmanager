<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;

/**
 * Class ProjectTask Entity
 *
 * @package NwManager\Entities;
 */
class ProjectTask extends AbstractEntity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $tables = 'project_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'project_id',
		'name',
        'start_date',
        'due_date',
        'status',
	];
    
    /**
     * Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
