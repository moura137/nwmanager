<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;

/**
 * Class ProjectNote Entity
 *
 * @package NwManager\Entities;
 */
class ProjectNote extends AbstractEntity
{
    protected $tables = 'project_notes';

    protected $fillable = [
		'project_id',
		'title',
		'note',
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
