<?php
namespace CursoLaravel\Services;

use CursoLaravel\Repositories\ProjectTaskRepository;
use CursoLaravel\Validators\ProjectTaskValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
{
    /**
     * @var ProjectTaskRepository
     */
    protected $repository;

    /**
     * @var ProjectTaskValidator
     */
    protected $validator;

    /**
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskValidator $validator
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @return $this
     */
    private function findWithRelationship()
    {
        return $this->repository->with(['project']);
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->findWithRelationship()->all();
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function find($id)
    {
        try {
            return $this->findWithRelationship()->find($id);
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @return array|mixed
     * @throws \Exception
     */
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch(ValidatorException $e) {
            return [
                'error'    => true,
                'messages' => $e->getMessageBag()
            ];
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param array $data
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'messages' => $e->getMessageBag()
            ];
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $this->repository->delete($id);
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}