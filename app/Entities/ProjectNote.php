<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;
use NwManager\Entities\User;

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
        'user_id',
        'title',
        'note',
    ];

    /**
     * Description Entity
     *
     * @return string
     */
    public function getName()
    {
        return $this->title;
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

    /**
     * Activities
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function activities()
    {
        return $this->morphMany(Activity::class, 'entity');
    }

    /**
     * Is User
     *
     * @param int $userId
     *
     * @return boolean
     */
    public function isUser($userId)
    {
        return (bool) ($this->user_id == $userId);
    }
}
