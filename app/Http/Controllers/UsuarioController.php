<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Helpers\Constantes;
use App\Helpers\LogHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Usuario;
use App\Models\Roles;
use App\Models\Institucion;
use Illuminate\Support\Facades\Hash;
use Validator;

class UsuarioController extends Controller
{

    /**
     * index()
     * List all users
     */

     /**
     *
     *  @OA\Get(path="/usuarios/list",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos los usuarios registrados activos o no activos con los roles asignados.",
     *     summary="Lista todos los usuarios",
     *     operationId="usuariosList",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el listado de Usuarios",
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
     *                      @OA\Property(property ="institucion",type="object",description="Institucion asignada al usuario",
     *                              @OA\Property(property ="id",type="integer",description="Id de la institucion"),
     *                              @OA\Property(property ="nombre_institucion",type="string",description="Nombre de la institucion"),
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

    public function index()
    {
        $user = Usuario::with('roles', 'institucion')->get();
        if (!$user) {
            return Http::respuesta(Http::retError, "Resource Usuario not found");
        }
        return Http::respuesta(Http::retOK, $user);
    }



     /**
     * me()
     * Me profile
     */

     /**
     *
     *  @OA\Get(path="/usuarios/me",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos los datos del usuario actual menos los ocultos, no es necesario que se envíen parámetros pero sí es necesario estar logueado.",
     *     operationId="usuariosMe",
     *     summary="Muestra los datos del usuario logueado",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el perfil del usuario logueado",
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

    public function me()
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return Http::respuesta(Http::retError, "Resource Usuario not found");
        }

        return Http::respuesta(Http::retOK, Usuario::with('roles')->where('id',$usuario->id)->first());
    }


    /**
     * findByIdUsuario()
     * Buscar perfil de usuario por id_usuario
     */

     /**
     *
     *  @OA\Get(path="/usuarios/findbyid/{id_usuario}",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos datos de un usuario específico encontrado por su id, los datos ocultos no son devueltos.",
     *     summary="Muestra los datos de un usuario específico encontrado por su id",
     *     operationId="usuariosFindById",
     *     @OA\Parameter(
     *         name="id_usuario",
     *         in="path",
     *         description="ID del usuario",
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

    public function findByIdUsuario($id_usuario)
    {
        if(!$id_usuario){
            return Http::respuesta(Http::retError, "Parámetro vacío");
        }

        $usuario = Usuario::with('roles')->where('id',$id_usuario)->first();

        if (!$usuario) {
            return Http::respuesta(Http::retError, "Resource Usuario not found");
        }

        return Http::respuesta(Http::retOK, $usuario);
    }

    /**
     * findByNickname()
     * Buscar Usuario nickname
     */

     /**
     *
     *  @OA\Get(path="/usuarios/findbynickname/{nickname}",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos los datos de un usuario específico encontrado por su nickname, los datos ocultos no son devueltos.",
     *     summary="Muestra los datos de un usuario específico encontrado por su id",
     *     operationId="findByNickname",
     *     @OA\Parameter(
     *         name="nickname",
     *         in="path",
     *         description="Nickname del usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Retorna todos los datos de un usuario específico",
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
     *                      @OA\Property(property ="institucion",type="object",description="Institucion del usuario",
     *                              @OA\Property(property ="id",type="integer",description="Id de la institucion"),
     *                              @OA\Property(property ="nombre_institucion",type="string",description="Nombre de la institucion"),
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

     public function findByNickname($nickname) {
        if(!$nickname){
            return Http::respuesta(Http::retError, "Parámetro vacío");
        }

        $usuario = Usuario::with('roles', 'institucion')->where('usuario',$nickname)->first();

        if (!$usuario) {
            return Http::respuesta(Http::retNotFound, "Usuario no encontrado");
        }

        return Http::respuesta(Http::retOK, $usuario);
     }


    /**
     * store()
     * Create user with default ROLE_USER
     */

     /**
     *
     *  @OA\Post(path="/usuarios/create",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Crea un usuario nuevo, el campo usuario es el nickname que como regla principal para registrar un usuario nuevo este
     *                  no debe de existir en dicho campo, éste además se crea con un rol predeterminado: ROLE_USER.",
     *     summary="Crea un nuevo usuario con rol predeterminado: ROLE_USER, osea rol_id: 2",
     *     operationId="usuariosCreate",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el resultado del registro",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(property="datos",description="Datos del resultado de la api",type="string"),
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
     *
     *     @OA\RequestBody(
     *          description="Datos de nuevo usuario",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required ={"nombre","usuario","hash"},
     *                  @OA\Property(
     *                      property="nombre",
     *                      description="Nombre del usuario",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="usuario",
     *                      description="Nickname del usuario",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="hash",
     *                      description="Cláve de ingreso al sistema encriptada md5",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="id_institucion",
     *                      description="Id de la institucion",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *      )
     *
     *
     *  )
     *
     */

    public function store(Request $request)
    {
        $usuario = Auth::user();

        $validator = Validator::make($request->all(), [
            'nombre'    => 'required|string',
            'usuario'   => 'required', //'usuario' => 'min:8|required|unique:ds_usuario',  //Se puede implementar esta validación para usuario repetido.
            'hash'      => 'required',
            'id_institucion' => 'required|integer'
        ]);

        if($validator->fails()){
            return Http::respuesta(Http::retError, "Datos invalidos");
        }

        if(!Institucion::where('id', $request->id_institucion)){
            return Http::respuesta(Http::retError, "No existe la institucion solicitada.");
        }
        /**
        * Log ALERT
        */
        LogHelper::alert('Se inició proceso de creación de usuario, nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);

        /**
        * Validando si ya existe el usuario que se intenta crear
        */
        $query = Usuario::where('usuario', $request->usuario)->first();
        if($query){
            return Http::respuesta(Http::retError, "Usuario ya existe!.");
        }

        DB::beginTransaction();
        try {

            $user = new Usuario();
            $user->nombre          = $request->nombre;
            $user->usuario         = $request->usuario;
            $user->hash            = $request->hash;
            $user->id_institucion  = $request->id_institucion;
            $user->password        = $user->generateHash($request->hash);
            $user->cambio          = 0;
            $user->activo          = 1;

            if($user->save()){
                $user->roles()->attach(Roles::where('rol_nombre', 'ROLE_USER')->first());
            }
        }
        catch (\Exception $e)
        {
            DB::rollback();
            LogHelper::error("Crear usuario: error al registrar el usuario:{$request->nombre} ({$request->usuario}). " . "Error: (".$e->getCode().") ".$e->getMessage());
            return Http::respuesta(Http::retError, ['resultado' => "Error: (".$e->getCode().") ".$e->getMessage()]);
        }

        DB::commit();

        /**
        * Log ALERT
        */
        LogHelper::alert('Usuario creado correctamente (nombre: '.$user->nombre.', usuario: '.$user->usuario.'), nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);


        return Http::respuesta(Http::retOK, 'Usuario creado correctamente');
    }


    /**
     * update()
     * Update user
     */

     /**
     *
     *  @OA\Put(path="/usuarios/update",
     *     tags={"Usuarios"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Actualiza la data de un usuario específico que se identifica por su id. El campo id_usuario es obligatorio ya que con éste se identifica el usuario a modificar.
     *                  Los demás campos son opcionales, si uno de estos es enviado se reemplaza la info actual por la info enviada",
     *     summary="Actualiza la data del usuario, sólo id_usuario es obligatorio",
     *     operationId="usuariosUpdate",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el usuario que ha sido modificado",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(property="datos",description="Datos del resultado de la api",type="string"),
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
     *
     *     @OA\RequestBody(
     *          description="Datos del usuario a modificar. Sólo id_usuario es obligatorio, todos los demás son opcionales.",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required ={"id_usuario"},
     *                  @OA\Property(
     *                      property="id_usuario",
     *                      description="Id del usuario a modificar",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="nombre",
     *                      description="Nombre del usuario",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="usuario",
     *                      description="Nickname del usuario",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="hash",
     *                      description="Cláve de ingreso al sistema encriptada md5",
     *                      type="string"
     *                  ),
     *                  @OA\Property(
     *                      property="cambio",
     *                      description="Campo destinado para concer si el usuario ya cambió la contraseña asignada defecto (0,1)",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="activo",
     *                      description="Si el usuario está activo o no (0,1)",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="modulo",
     *                      description="Número de módulo al que pertenece el usuario",
     *                      type="integer"
     *                  ),
     *                  @OA\Property(
     *                      property="roles",
     *                      description="Arreglo de roles que posee el usuario",
     *                      type="array",
     *                      @OA\Items(
     *                          @OA\Property(property ="rol_id",type="integer",description="Id del rol")
     *                      ),
     *                  ),
     *              )
     *          )
     *      )
     *
     *
     *  )
     *
     */

    public function update(Request $request)
    {
        $usuario = Auth::user();

        $validator = Validator::make($request->all(), [
               'id_usuario' => 'required|integer|min:1',
               'nombre'     => 'nullable|string',
               'usuario'    => 'nullable|string',
               'hash'       => 'nullable|string',
               'cambio'     => 'nullable|integer|min:0|max:1',
               'activo'     => 'nullable|integer|min:0|max:1',
               'modulo'     => 'nullable|integer|min:0|max:1',
               'roles'      => 'nullable|array'
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        /**
        * Log ALERT
        */
        LogHelper::alert('Se inició proceso de modificación de usuario, nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);

        /**
        * Validando si el id_usuario enviado existe y encontrando dicho usuario para modificarlo
        */
        $user = Usuario::where('id', $request->id_usuario)->first();

        if(!$user){
            return Http::respuesta(Http::retError, "Usuario no encontrado");
        }

        DB::beginTransaction();

        try {
            if( isset($request->nombre) )   $user->nombre      =   $request->nombre;
            if( isset($request->usuario) )  $user->usuario     =   $request->usuario;
            if( isset($request->hash) ){
                                            $user->hash        =   $request->hash;
                                            $user->password    =   $user->generateHash($request->hash);
            }
            if( isset($request->cambio) )   $user->cambio      =   $request->cambio;
            if( isset($request->activo) )   $user->activo      =   $request->activo;
            if( isset($request->modulo) )   $user->modulo      =   $request->modulo;

            if($request->roles){
                DB::table('ds_roles_usuario')->where('usuario_id',$request->id_usuario)->delete();
                foreach ($request->roles as $val ) {
                    $rol = Roles::where('id',$val['rol_id'])->first();
                    if($rol){
                        $user->roles()->attach($rol);
                    }
                }
            }

            $user->save();
        }
        catch (\Exception $e)
        {
            DB::rollback();
            LogHelper::error("Modificar usuario: error al modificar el usuario:{$request->nombre} ({$request->usuario}). " . "Error: (".$e->getCode().") ".$e->getMessage());
            return Http::respuesta(Http::retError, ['resultado' => "Error: (".$e->getCode().") ".$e->getMessage()]);
        }

        DB::commit();

        /**
        * Log ALERT
        */
        LogHelper::alert('Usuario modificado correctamente (nombre: '.$user->nombre.', usuario: '.$user->usuario.'), nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);

        return Http::respuesta(Http::retOK, Usuario::with('roles')->where('id',$user->id)->first());
    }



}
