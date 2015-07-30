<?php

namespace NwManager\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class AbstractService
 *
 * @package NwManager\Services;
 * @abstract
 */
abstract class AbstractService
{
    /**
     * @var AbstractRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * Get Errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
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

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Update
     *
     * @param Entity|int $id
     * @param array      $data
     *
     * @return Model
     */
    public function update($id, array $data = [])
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

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
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
        try {
            return $this->repository->delete($id);
            
        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Parse Error
     *
     * @param  \Exception $e
     *
     * @return array
     */
    protected function parseError(\Exception $e)
    {
        if ($e instanceof ValidatorException) {
            return $e->toArray();
        }

        return [
            'error' => 'error_internal',
            'error_description' => $e->getMessage(),
        ];
    }
}