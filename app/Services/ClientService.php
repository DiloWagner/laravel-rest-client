<?php
namespace CursoLaravel\Services;

use CursoLaravel\Exceptions\ClientDatabaseException;
use CursoLaravel\Repositories\ClientRepository;
use CursoLaravel\Validators\ClientValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $repository;

    /**
     * @var ClientValidator
     */
    protected $validator;

    /**
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->repository->all();
    }

    /**
     * @param $id
     * @return mixed
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function find($id)
    {
        try {
            return $this->repository->find($id);
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
        } catch (QueryException $qe) {
            throw new ClientDatabaseException($qe->getCode());
        } catch (\Exception $e) {
            throw $e;
        }
    }
}