<?php
namespace CursoLaravel\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectMembers extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['project_id', 'user_id'];

    /**
     * @var array
     */
    protected $fillable = ['project_id', 'user_id'];

    /**
     * @var bool
     */
    public $timestamps = false;
}
