<?php
namespace CursoLaravel\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'progress', 'status', 'due_date'];
}
