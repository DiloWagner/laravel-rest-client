<?php
namespace CursoLaravel\Services;

use CursoLaravel\Repositories\ProjectNoteRepository;
use CursoLaravel\Validators\ProjectNoteValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteService
{
    /**
     * @var ProjectNoteRepository
     */
    protected $repository;

    /**
     * @var ProjectNoteValidator
     */
    protected $validator;

    /**
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteValidator $validator
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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