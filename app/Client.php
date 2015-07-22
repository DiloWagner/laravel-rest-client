<?php

namespace CursoLaravel;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'responsible', 'email', 'phone', 'address', 'obs'];
}
