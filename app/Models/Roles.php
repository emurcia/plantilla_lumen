<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'ds_roles';

    protected $fillable = ['rol_nombre'];

    protected $primaryKey = 'id';

    protected $appends = ['rol'];

    // exclude created_at and Updated_at field in entity
    public $timestamps = false;

    function getRolAttribute()
    {
        return strtolower(preg_replace('/\s/', '-', $this->rol_nombre));
    }


}