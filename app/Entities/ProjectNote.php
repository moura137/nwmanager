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
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $tables = 'project_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
