<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;
use NwManager\Entities\User;

/**
 * Class ProjectFile Entity
 *
 * @package NwManager\Entities;
 */
class ProjectFile extends AbstractEntity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $tables = 'project_files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id',
        'user_id',
        'description',
        'file',
        'extension',
        'size',
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