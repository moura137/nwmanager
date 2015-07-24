<?php

namespace NwManager\Entities;

/**
 * Class Client Entity
 *
 * @package NwManager\Entities;
 */
class Client extends AbstractEntity
{
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
        return $this->hasMany('NwManager\Entities\Project');
    }
}
