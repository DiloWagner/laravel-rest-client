<?php
namespace CursoLaravel\Services;

use CursoLaravel\Entities\Project;
use CursoLaravel\Exceptions\NotfoundException;
use CursoLaravel\Repositories\ProjectRepository;
use CursoLaravel\Validators\ProjectValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{
    /**
     * @var ProjectRepository
     */
    protected $repository;

    /**
     * @var ProjectValidator
     */
    protected $validator;

    /**
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @return $this
     */
    private function findWithRelationship()
    {
        return $this->repository->with(['owner', 'client']);
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
     * @throws NotfoundException
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
     * @return mixed
     */
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch(ValidatorException $e) {
            return [
                'error' => true,
                'messages' => $e->getMessageBag()
            ];
        }
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
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
        }
    }

    /**
     * @param $id
     */
    public function destroy($id)
    {
        $this->repository->delete($id);
    }
}