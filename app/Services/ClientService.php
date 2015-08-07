<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Validators\ClientValidator;

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
     * @param array      $data
     *
     * @return bool
     */
    public function delete($id, array $data = array())
    {
        $entity = $this->repository->find($id);

        // Valida Se existe Projetos
        $count = $entity->projects()->count();
        if ($count) {
            $this->errors = [
                'error' => 'validation_exception',
                'error_description' => ['projects' => [trans('services.exists_projects', ['count' => $count])]],
            ];
            return false;
        }

        return parent::delete($entity->id, $data);
    }
}