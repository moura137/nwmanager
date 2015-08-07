<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectTaskRepository;
use NwManager\Validators\ProjectTaskValidator;
use NwManager\Repositories\Criterias\InputCriteria;
use Prettus\Validator\Contracts\ValidatorInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProjectTaskService
 *
 * @package NwManager\Services;
 */
class ProjectTaskService extends AbstractService
{    
    /**
     * Construct
     *
     * @param ProjectTaskRepository $repository
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
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
        $project_id = isset($data['project_id']) ? $data['project_id'] : 0;

        $entity = $this->repository->find($id)->fill($data);

        $data = array_merge($data, $entity->toArray());
        
        try {
            $this->validator
                ->with($data)
                ->setId($id)
                ->passesOrFail(ValidatorInterface::RULE_UPDATE);
                
            return $this->repository
                ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
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
     *
     * @return bool
     */
    public function delete($id, array $data = array())
    {
        try {
            $project_id = isset($data['project_id']) ? $data['project_id'] : 0;

            return $this->repository
                ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
                ->delete($id);
            
        } catch (ModelNotFoundException $e) {
            throw $e;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }
}