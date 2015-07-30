<?php
namespace CursoLaravel\Http\Controllers;

use CursoLaravel\Exceptions\Enums\Error;
use CursoLaravel\Exceptions\RecordNotFoundException;
use CursoLaravel\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use CursoLaravel\Http\Requests;
use Illuminate\Http\Response;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @param ProjectService $service
     */
    public function __construct(ProjectService $service)
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

    /**
     * @param $project
     * @return mixed
     */
    public function members($project)
    {
        try {
            return $this->service->findMembersByProject($project);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param $project
     * @return mixed
     */
    public function addMember(Request $request, $project)
    {
        try {
            $member = $request->get('member', 0);
            return $this->service->addMember($project, $member);
        } catch (RecordNotFoundException $re) {
            return response()->json([
                'message' => $re->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param Request $request
     * @param $project
     * @return mixed
     */
    public function removeMember(Request $request, $project)
    {
        try {
            $member = $request->get('member', 0);
            return $this->service->removeMember($project, $member);
        } catch (RecordNotFoundException $re) {
            return response()->json([
                'message' => $re->getMessage(),
            ], Response::HTTP_NOT_FOUND);
        } catch(ModelNotFoundException $mnf) {
            return response()->json([
                'message' => Error::RECORD_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @param $member
     * @param $project
     * @return mixed
     */
    public function isMember($project, $member)
    {
        $isMember = $this->service->isMember($project, $member);
        return response()->json([
            'response' => $isMember,
        ], Response::HTTP_OK);
    }
}