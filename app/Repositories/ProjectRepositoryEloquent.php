<?php
namespace CursoLaravel\Repositories;

use CursoLaravel\Entities\Project;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }
}