<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;

/**
 * Class Activity Entity
 *
 * @package NwManager\Entities;
 */
class Activity extends AbstractEntity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $tables = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'user_name',
        'project_id',
        'project_name',
        'entity_id',
        'entity_type',
        'entity_desc',
        'event',
	];

    /**
     * Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Entity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function entity()
    {
        return $this->morphTo();
    }
}
