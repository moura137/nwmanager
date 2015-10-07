<?php

namespace NwManager\Entities;

use NwManager\Entities\Project;

/**
 * Class Client Entity
 *
 * @package NwManager\Entities;
 */
class Client extends AbstractEntity
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clients';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'responsible',
        'email',
        'phone',
        'address',
        'obs',
    ];

    /**
     * Projects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
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
     * Set Email
     *
     * @param string $value
     *
     * @return void
     */
    public function setEmailAttribute($value)
    {
        if (! empty($value)) {
            $this->attributes['email'] = strtolower($value);
        }
    }
}
