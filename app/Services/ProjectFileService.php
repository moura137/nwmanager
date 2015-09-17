<?php

namespace NwManager\Services;

use NwManager\Repositories\Contracts\ProjectFileRepository;
use NwManager\Validators\ProjectFileValidator;
use NwManager\Upload\Upload;
use NwManager\Repositories\Criterias\InputCriteria;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
    private function makeFolder($project_id)
    {
        return sprintf("nwmanager/project-%d/", $project_id);
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
            $folder     = $this->makeFolder($project_id);
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
                ->resetModel()
                ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
                ->find($id);

            $success = $this->repository->delete($entity->id);

            if ($success) {
                $folder = $this->makeFolder($project_id);
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

    /**
     * Delete All
     *
     * @param array $files
     * @param array $project_id
     *
     * @return bool
     */
    public function deleteAll($files, $project_id)
    {
        $result = ['fails' => [], 'success' => []];

        $files = (array) $files;
        $data = compact('project_id');

        foreach ($files as $idFile):
            $idFile = intval($idFile);

            try {
                $success = $this->delete($idFile, $data);

                if ($success) {
                    array_push($result['success'], $idFile);
                } else {
                    array_push($result['fails'], $idFile);
                }
            } catch (\Exception $e) {
                array_push($result['fails'], $idFile);
            }
        endforeach;

        return $result;
    }

    /**
     * Delete File
     *
     * @param Entity|int $id
     * @param array      $data
     *
     * @return bool
     */
    public function getFile($id, array $data = array())
    {
        try {
            $project_id = isset($data['project_id']) ? $data['project_id'] : 0;

            $entity = $this->repository
                ->resetModel()
                ->pushCriteria(new InputCriteria(['project_id' => $project_id]))
                ->find($id);

            $folder = $this->makeFolder($project_id);
            $file = $this->upload->readFile($entity->file, $folder);

            if (!$file) {
                abort(404);
            }

            $mime = $this->upload->mimeType($entity->file, $folder);

            return [
                'file' => $file,
                'mime' => $mime,
                'filename' => $entity->file,
            ];

        } catch (ModelNotFoundException $e) {
            throw $e;
            
        } catch (NotFoundHttpException $e) {
            throw $e;

        } catch (\Exception $e) {
            $this->errors = $this->parseError($e);
            return false;
        }
    }
}