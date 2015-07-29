<?php

namespace NwManager\Entities;

use NwManager\Entities\User;
use NwManager\Entities\Client;

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
}
