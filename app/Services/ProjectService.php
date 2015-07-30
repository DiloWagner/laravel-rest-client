<?php
namespace CursoLaravel\Services;

use CursoLaravel\Entities\User;
use CursoLaravel\Exceptions\RecordNotFoundException;
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

    /**
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function findMembersByProject($id)
    {
        try {
            return $this->repository->with(['members'])->find($id)->members;
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $projectId
     * @param $memberId
     * @return mixed
     * @throws \Exception
     */
    public function addMember($projectId, $memberId)
    {
        try {
            $member = User::find($memberId);
            if(! ($member instanceof User)) {
                throw new RecordNotFoundException(sprintf("Member with id [%s] not found", $memberId));
            }
            return $this->repository->with(['members'])->find($projectId)->members()->attach($memberId);
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $projectId
     * @param $memberId
     * @return mixed
     * @throws \Exception
     */
    public function removeMember($projectId, $memberId)
    {
        try {
            $project = $this->repository->with(['members'])->find($projectId);
            $members = $project->members;
            if(! ($members->contains($memberId))) {
                throw new RecordNotFoundException(sprintf("Member with id [%s] not found", $memberId));
            }
            return $project->members()->detach($memberId);
        } catch (ModelNotFoundException $mnf) {
            throw $mnf;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $projectId
     * @param $memberId
     * @return mixed
     * @throws \Exception
     */
    public function isMember($projectId, $memberId)
    {
        $project = $this->repository->with(['members'])->find($projectId);
        $members = $project->members;
        if(! ($members->contains($memberId))) {
            return false;
        }
        return true;
    }
}