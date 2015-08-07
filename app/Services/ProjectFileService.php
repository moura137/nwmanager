<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectFileRepository;
use NwManager\Validators\ProjectFileValidator;
use NwManager\Upload\Upload;
use NwManager\Repositories\Criterias\InputCriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class ProjectFileService
 *
 * @package NwManager\Services;
 */
class ProjectFileService extends AbstractService
{
    /**
     * @var Upload
     */
    protected $upload;
    
    /**
     * Construct
     *
     * @param ProjectFileRepository $repository
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileValidator $validator, Upload $upload)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->upload = $upload;
    }

    /**
     * Set Folder
     *
     * @param string
     */
    private function setFolder($project_id)
    {
        return sprintf("project-%d/", $project_id);
    }

    /**
     * Create File
     *
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data)
    {
        try {
            // Validação
            $this->validator
                ->with($data)
                ->passesOrFail();
            
            // Insert Database
            $project_id = $data['project_id'];
            $file       = $data['file'];
            $folder     = $this->setFolder($project_id);
            $dataFile   = $this->upload->parseFile($file, null, $folder);

            $attributes = [
                'project_id'    => $project_id,
                'user_id'       => $data['user_id'],
                'description'   => $data['description'],
                'file'          => $dataFile['name'],
                'extension'     => $dataFile['extension'],
                'size'          => $dataFile['size'],
            ];
            $entity = $this->repository->create($attributes);

            // Upload File
            $name = sprintf("%06d/", $entity->id);
            $dataFile = $this->upload->uploadFile($file, $name, $folder);

            $entity->file = $dataFile['name'];
            $entity->save();

            if (!$dataFile) {
                throw new \RuntimeException("Erro ao efetuar upload.");
            }

            return $entity;

        } catch (\Exception $e) {
            
            if (isset($entity) && $entity->exists) {
                $entity->delete();
            }

            $this->errors = $this->parseError($e);
            return false;
        }
    }

    /**
     * Delete File
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

            $entity = $this->repository
                ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
                ->find($id);

            $success = $this->repository->delete($entity->id);

            if ($success) {
                $folder = $this->setFolder($project_id);
                $this->upload->deleteFile($entity->file, $folder);
            }

            return $success;

        } catch (ModelNotFoundException $e) {
            throw $e;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }
}