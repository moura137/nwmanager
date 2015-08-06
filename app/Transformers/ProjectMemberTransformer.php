<?php

namespace NwManager\Transformers;

use NwManager\Entities\User;

/**
 * Class ProjectMemberTransformer
 *
 * @package NwManager\Transformers;
 */
class ProjectMemberTransformer extends AbstractTransformer
{
    /**
     * Transform the User entity for display member
     *
     * @param User $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'member_id' => (int) $user->id,
            'name'      => $user->name,
            'email'     => $user->email,
        ];
    }
}