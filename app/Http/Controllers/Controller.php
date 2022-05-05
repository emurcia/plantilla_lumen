<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\Roles;
use Exception;

class Controller
{
    /**
     * @OA\Info( title="API Plantilla", version="1.0",
     *   description="Backend Documentación"
     * ),
     * @OA\SecurityScheme(
     *      securityScheme="token",
     *      type="apiKey",
     *      name="Authorization",
     *      in="header"
     *     ),
     */

    public function respondWithToken($token)
    {

        try {
            $usuario = Auth::User();

            $vars = [
                'id_usuario'              => (int) $usuario->id,
                'usuario'                 => $usuario->usuario,
                'nombre'                  => $usuario->nombre,
                'id_institucion'          => $usuario->institucion->id,
                'nombre_institucion'      => $usuario->institucion->nombre_institucion . '-' . $usuario->institucion->abrebiatura,
                'cambio_password'         => (int) $usuario->cambio,
                'modulo'                  => (int) $usuario->modulo,
                'roles'                   => [],
            ];

            $vars['roles']['activos']     = $usuario->roles;
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => $vars,
                'expires_in' => Auth::factory()->getTTL() * 60
            ]);
        } catch (Exception $e) {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ]);
        }
    }
}
