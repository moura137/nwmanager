<?php

namespace NwManager\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use NwManager\Repositories\Criterias\InputCriteria;

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
     * @param array      $criterias
     *
     * @return Model
     */
    public function update($id, array $data = [], $criterias = [])
    {
        $entity = $this->repository->find($id)->fill($data);

        $data = array_merge($data, $entity->toArray());

        try {
            $this->validator
                ->with($data)
                ->setId($id)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);

            return $this->repository
                ->resetModel()
                ->pushCriteria(new InputCriteria($criterias))
                ->update($data, $id);

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
     * @param array      $criterias
     *
     * @return bool
     */
    public function delete($id, array $data = [], $criterias = [])
    {
        try {
            return $this->repository
                ->resetModel()
                ->pushCriteria(new InputCriteria($criterias))
                ->delete($id);

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
            'error_description' => sprintf("%s, %s in %s:(%s)", $e->getMessage(), get_class($e), $e->getFile(), $e->getLine()),
        ];
    }
}