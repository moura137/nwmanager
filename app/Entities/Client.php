<?php

namespace NwManager\Entities;

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
