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
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var UserValidator
     */
    protected $validator;
    
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
     *
     * @return bool
     */
    public function delete($id)
    {
        $entity = $this->repository->find($id);

        // Valida Se existe Projetos
        $count = $entity->projects()->count();
        if ($count > 1) {
            $this->errors = [
                'error' => 'validation_exception',
                'error_description' => ['projects' => [trans('services.exists_projects', ['count' => $count])]],
            ];
            return false;
        }
        
        return $this->repository->delete($entity->id);
    }
}