<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Helpers\LogHelper;
use App\Models\Roles;
use App\Models\Usuario;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Validator;

class AuthController extends Controller
{
    /**
     * Obtiene el JWT por medio de las credenciales.
     *
     * @param  Request  $request
     * @return Response
     *
     */

    /**
     *
     *  @OA\Post(path="/api/autenticar",
     *     tags={"Autenticar"},
     *     description="Permite autenticarse y devuelve jwt token para autorizar acceso a endpoints protegidos.",
     *     summary="Login",
     *     operationId="autenticar",
     *     @OA\Response(
     *         response="200",
     *         description="Se ha iniciado sesión conrrectamente",
     *         @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="access_token",
     *                  type="string",
     *                  description="Bearer token"
     *              ),
     *              @OA\Property(
     *                  property="token_type",
     *                  type="string",
     *                  description="Token type"
     *              ),
     *              @OA\Property(
     *                  property="user",
     *                  type="array",
     *                  description="Datos del usuario",
     *                  @OA\Items(
     *                      @OA\Property(
     *                          property="id",
     *                          type="integer",
     *                          description="Id usuario"
     *                      ),
     *                      @OA\Property(
     *                          property="usuario",
     *                          type="string",
     *                          description="Usuario del sistema"
     *                      ),
     *                      @OA\Property(
     *                          property="activo",
     *                          type="string",
     *                          description="Estado del usuario"
     *                      ),
     *                      @OA\Property(
     *                          property="nombre",
     *                          type="string",
     *                          description="Nombre del usuario"
     *                      ),
     *                      @OA\Property(
     *                          property="codigo",
     *                          type="string",
     *                          description="Código del usuario"
     *                      ),
     *                      @OA\Property(
     *                          property="cambio",
     *                          type="string",
     *                          description="Bandera para cambio de contraseña por defecto"
     *                      ),
     *                      @OA\Property(
     *                          property="modulo",
     *                          type="string",
     *                          description="Número de módulo al que pertenece el usuario"
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(
     *                  property="expires_in",
     *                  type="integer",
     *                  description="Duración token"
     *              ),
     *          ),
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Recurso no encontrado. La petición no devuelve ningún dato",
     *     ),
     *     @OA\Response(
     *         response="403",
     *         description="Acceso denegado. No se cuenta con los privilegios suficientes",
     *         @OA\JsonContent(
     *              @OA\Property(property ="error",type="string",description="Mensaje de error de privilegios insuficientes")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error de Servidor.",
     *         @OA\JsonContent(
     *              @OA\Property(property ="error",type="string",description="Error de Servidor")
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *     description="Credenciales de ingreso",
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/json",
     *         @OA\Schema(
     *             type="object",
     *             required ={"usuario","password"},
     *             @OA\Property(
     *                 property="usuario",
     *                 description="Nombre de usuario de ingreso al sistema",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 description="Cláve de ingreso al sistema",
     *                 type="string"
     *             ),
     *         )
     *     )
     *  )
     * )
     */
    public function autenticar(Request $request)
    {

        $credentials = $request->only(['usuario', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Cierra la sesión del usuario (Invalidando su token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function salir()
    {
        auth()->logout();

        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }

    /**
     * Refresca el token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refrescar()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}