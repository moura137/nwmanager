<?php

namespace NwManager\Entities;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class OAuthClient Entity
 *
 * @package NwManager\Entities;
 */
class OAuthClient extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'oauth_clients';
}
