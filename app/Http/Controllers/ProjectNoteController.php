<?php
namespace CursoLaravel\Http\Controllers;

use CursoLaravel\Exceptions\Enums\Error;
use CursoLaravel\Services\ProjectNoteService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use CursoLaravel\Http\Requests;
use Illuminate\Http\Response;

class ProjectNoteController extends Controller
{
    /**
     * @var ProjectNoteService
     */
    private $service;

    /**
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteService $service)
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
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
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
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            return $this->service->update($request->all(), $id);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => Error::UNEXPECTED_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
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
}