<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Usuario extends Model implements AuthenticatableContract, AuthorizableContract, JWTSubject
{

    use Authenticatable, Authorizable;

    private $textseg='Minsal.2021';

    protected $table = 'ds_usuario';

    protected $primaryKey = 'id';

    protected $fillable = [
        'usuario',
        'hash',
        'activo',
        'updated_at',
        'created_at',
        'password'
    ];

    protected $hidden = [
        'hash',
        'created_at',
        'updated_at',
        'password'
    ];

    public function roles()
    {
        return $this->belongsToMany(Roles::class, 'ds_roles_usuario');
    }

    public function institucion()
    {
        return $this->belongsTo(Institucion::class, 'id_institucion', 'id');
    }


      /**
     * Obtiene el identificador que se guardará en el Claim de JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Devuelve el valor de la llave del arreglo, contiene toas las claims personalizadas que se agregaron al jWT
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function hasRoleId($role_id)
    {
        foreach ($this->roles as $role) {
            if ($role->id == $role_id) {
                return true;
            }
        }
        return false;
    }


    // Generate has for user
    public function generateHash($pass)
    {

        //$password_hash = md5($param . ":" . $pass);
        $password_hash = app('hash')->make($pass);
        return $password_hash;
    }

    /**
     * Setters and Getters
     */
    private function setTextSeg($textseg)
    {
        $this->textseg = $textseg;
    }

    private function getTextSeg()
    {
        return $this->textseg;
    }


}
