<?php
namespace CursoLaravel\Http\Controllers;

use CursoLaravel\Exceptions\ClientDatabaseException;
use CursoLaravel\Exceptions\Enums\Error;
use CursoLaravel\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use CursoLaravel\Http\Requests;
use Illuminate\Http\Response;

class ClientController extends Controller
{
    /**
     * @var ClientService
     */
    private $service;

    /**
     * @param ClientService $service
     */
    function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->service->all();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function show($id)
    {
        try {
            return $this->service->find($id);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => Error::UNEXPECTED_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return array|\Illuminate\Http\JsonResponse|mixed
     */
    public function update(Request $request, $id)
    {
        try {
            return $this->service->update($request->all(), $id);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => Error::UNEXPECTED_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(ClientDatabaseException $ce) {
            return response()->json([
                'message' => $ce->getErrorMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        } catch(\Exception $e) {
            return response()->json([
                'message' => Error::UNEXPECTED_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
