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
    protected $tables = 'project_tasks';

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
