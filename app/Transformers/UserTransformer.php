<?php

namespace NwManager\Transformers;

use NwManager\Entities\User;

/**
 * Class UserTransformer
 *
 * @package NwManager\Transformers;
 */
class UserTransformer extends AbstractTransformer
{

    protected $timestamps = true;

    /**
     * Construct
     *
     * @param boolean $timestamps
     */
    public function __construct($timestamps = true)
    {
        $this->timestamps = $timestamps;
    }

    /**
     * Transform the User entity
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        $return = [
            'id'        => (int) $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
        ];

        if ($this->timestamps) {
            $return['created_at'] = $this->formatDate($user->created_at, 'Y-m-d H:i:s');
            $return['updated_at'] = $this->formatDate($user->updated_at, 'Y-m-d H:i:s');
        }

        return $return;
    }
}