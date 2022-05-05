<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Helpers\LogHelper;
use App\Helpers\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Institucion;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Validator;

class CatalogoController extends Controller
{

   /**
     *  @OA\Get(path="/instituciones/list",
     *     tags={"Instituciones"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos las instituciones registradas en la tabla: instituciones.",
     *     summary="Lista todas las institucines",
     *     operationId="institucionesList",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el listado de instituciones",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(
     *                  property="datos",
     *                  description="Datos del resultado de la api",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property ="id",type="integer",description="Id de la institucion"),
     *                      @OA\Property(property ="nombre_institucion",type="string",description="Nombre de la institucion"),
     *                  ),
     *              ),
     *              @OA\Property(property ="entregado",type="string",description="Fecha hora de entrega"),
     *              @OA\Property(property ="consumo",type="number",description="Cant. recursos consumidos"),
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
     *              @OA\Property(property ="error",type="string",description="Error")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error de Servidor.",
     *         @OA\JsonContent(
     *              @OA\Property(property ="error",type="string",description="Error de Servidor")
     *         )
     *     ),
     * )
     *
     */

    public function getInstituciones(){

        $datos = Institucion::all();

        return Http::respuesta(null, $datos, true);

    }

    /**
     *
     *  @OA\Get(path="/usuarios/findByIdInstitucion/{id_institucion}",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos datos de un usuario específico encontrado por institucion, los datos ocultos no son devueltos.",
     *     summary="Muestra los datos de un usuario específico encontrado por institucion",
     *     operationId="usuariosFindById",
     *     @OA\Parameter(
     *         name="id_institucion",
     *         in="path",
     *         description="ID de la institucion",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el perfil de un usuario específico",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(
     *                  property="datos",
     *                  description="Datos del resultado de la api",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property ="id",type="integer",description="Id de usuario"),
     *                      @OA\Property(property ="usuario",type="string",description="Nickname de usuario"),
     *                      @OA\Property(property ="activo",type="integer",description="Activo/desactivo"),
     *                      @OA\Property(property ="nombre",type="string",description="Nombre de usuario"),
     *                      @OA\Property(property ="codigo",type="string",description="Codigo de usuario"),
     *                      @OA\Property(property ="cambio",type="integer",description="Cambio de contraseña"),
     *                      @OA\Property(property ="modulo",type="integer",description="Modulo al que pertenece el usuario"),
     *                      @OA\Property(property ="roles",type="array",description="Roles del usuario",
     *                          @OA\Items(
     *                              @OA\Property(property ="id",type="integer",description="Id del rol"),
     *                              @OA\Property(property ="rol_nombre",type="string",description="Nombre del rol"),
     *                              @OA\Property(property ="rol",type="string",description="Nombre del rol"),
     *                              @OA\Property(property ="pivot",type="array",description="Relación usuario roles",
     *                                  @OA\Items(
     *                                      @OA\Property(property ="usuario_id",type="integer",description="Id del usuario"),
     *                                      @OA\Property(property ="roles_id",type="integer",description="Id del rol")
     *                                  ),
     *                              )
     *                          ),
     *                      ),
     *                  ),
     *              ),
     *              @OA\Property(property ="entregado",type="string",description="Fecha hora de entrega"),
     *              @OA\Property(property ="consumo",type="number",description="Cant. recursos consumidos"),
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
     *              @OA\Property(property ="error",type="string",description="Error")
     *         )
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Error de Servidor.",
     *         @OA\JsonContent(
     *              @OA\Property(property ="error",type="string",description="Error de Servidor")
     *         )
     *     ),
     * )
     *
     */
    public function getUsuariosByIdInstitucion($id_institucion){

        if(!$id_institucion){
            return Http::respuesta(Http::retError, "Parámetro vacío");
        }

        $usuarios = Usuario::with('roles','institucion')->where('id_institucion',$id_institucion)->get();

        if (!$usuarios) {
            return Http::respuesta(Http::retError, "Resource Usuario not found");
        }

        return Http::respuesta(Http::retOK, $usuarios);
    }

}
