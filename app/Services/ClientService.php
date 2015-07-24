<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Support\MessageBag;

/**
 * Class ClientService
 *
 * @package NwManager\Services;
 */
class ClientService extends AbstractService
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;
    
    /**
     * Construct
     *
     * @param ClientRepository $repository
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)
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
        if ($entity->projects()->count() > 1) {
            $this->errors = [
                'error' => 'validation_exception',
                'error_description' => ['projects' => [trans('services.exists_projects')]],
            ];
            return false;
        }

        return $entity->delete();
    }
}