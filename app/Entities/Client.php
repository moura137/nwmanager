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
}
