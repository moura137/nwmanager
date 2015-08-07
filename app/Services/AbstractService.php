<?php

namespace NwManager\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            $entity = $this->repository->makeModel()->fill($data);
            $data = array_merge($data, $entity->toArray());

            $this->validator
                ->with($data)
                ->passesOrFail(ValidatorInterface::RULE_CREATE);

            return $this->repository->create($data);

        } catch (ModelNotFoundException $e) {
            throw $e;

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
        $entity = $this->repository->find($id)->fill($data);

        $data = array_merge($data, $entity->toArray());

        try {
            $this->validator
                ->with($data)
                ->setId($id)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
            return $this->repository->update($data, $id);

        } catch (ModelNotFoundException $e) {
            throw $e;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
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
        try {
            return $this->repository->delete($id);
        
        } catch (ModelNotFoundException $e) {
            throw $e;
            
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