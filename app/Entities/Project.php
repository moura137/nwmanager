<?php

namespace NwManager\Entities;

/**
 * Class Project Entity
 *
 * @package NwManager\Entities;
 */
class Project extends AbstractEntity
{
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
		return $this->belongsTo('NwManager\Entities\User');
	}

	/**
     * Client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function client()
	{
		return $this->belongsTo('NwManager\Entities\Client');
	}
}
