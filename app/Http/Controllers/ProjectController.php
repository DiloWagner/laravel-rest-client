<?php
namespace CursoLaravel\Http\Controllers;

use CursoLaravel\Services\ProjectService;
use Illuminate\Http\Request;
use CursoLaravel\Http\Requests;

class ProjectController extends Controller
{
    /**
     * @var ProjectService
     */
    private $service;

    /**
     * @param ProjectService $service
     */
    function __construct(ProjectService $service)
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
        return $this->service->find($id);
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
        return $this->service->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->service->destroy($id);
    }
}