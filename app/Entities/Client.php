<?php

namespace NwManager\Entities;

class Client extends AbstractModel
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
