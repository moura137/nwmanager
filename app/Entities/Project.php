<?php

namespace NwManager\Entities;

use NwManager\Entities\User;
use NwManager\Entities\Client;
use NwManager\Entities\ProjectNote;
use NwManager\Entities\ProjectTask;

/**
 * Class Project Entity
 *
 * @package NwManager\Entities;
 */
class Project extends AbstractEntity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'owner_id',
		'client_id',
		'name',
		'description',
		'progress',
		'status',
		'due_date',
	];
	
    /**
     * Owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function owner()
	{
		return $this->belongsTo(User::class);
	}

	/**
     * Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function client()
	{
		return $this->belongsTo(Client::class);
	}

    /**
     * Notes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notes()
    {
        return $this->hasMany(ProjectNote::class);
    }

    /**
     * Tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }

    /**
     * Members
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
