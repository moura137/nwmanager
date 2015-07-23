<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ClientRepository;
use NwManager\Validators\ClientValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

use \Exception;

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
     * Create
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data)
    {
        try {
            $this->validator
                ->with($data)
                ->passesOrFail(ValidatorInterface::RULE_CREATE);

            return $this->repository->create($data);

        } catch (ValidatorException $e) {
            return $e->toArray();

        } catch (Exception $e) {
            return [
                'error' => 'error_internal',
                'error_description' => 'Unexpected internal error.',
            ];
        }
    }

    /**
     * Update
     *
     * @param array $data
     * @param int   $id
     *
     * @return Model
     */
    public function update($id, array $data)
    {
        $entity = $this->repository->find($id);
        $entity->fill($data);
        $attributes = $entity->toArray();

        try {
            $this->validator
                ->with($attributes)
                ->setId($id)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
            return $this->repository->update($attributes, $id);

        } catch (ValidatorException $e) {
            return $e->toArray();

        } catch (Exception $e) {
            return [
                'error' => 'error_internal',
                'error_description' => 'Unexpected internal error.',
            ];
        }
    }
}