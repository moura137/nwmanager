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

        if (!$this->includeData) {
            $return['created_at'] = $this->formatDate($user->created_at, 'Y-m-d H:i:s');
            $return['updated_at'] = $this->formatDate($user->updated_at, 'Y-m-d H:i:s');
        }

        return $return;
    }
}