<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\UserRepository;
use NwManager\Validators\UserValidator;

/**
 * Class UserService
 *
 * @package NwManager\Services;
 */
class UserService extends AbstractService
{
    /**
     * Construct
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository, UserValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * Delete
     *
     * @param Entity|int $id
     * @param array      $data
     * @param array      $criterias
     *
     * @return bool
     */
    public function delete($id, array $data = [], $criterias = [])
    {
        $entity = $this->repository->find($id);

        // Valida Se existe Projetos
        $count = $entity->owner_projects()->count();
        if ($count) {
            $this->errors = [
                'error' => 'validation_exception',
                'error_description' => ['projects' => [trans('services.exists_projects', ['count' => $count])]],
            ];
            return false;
        }

        return parent::delete($entity->id, $data, $criterias);
    }
}