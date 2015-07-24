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
}