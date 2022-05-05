<?php

namespace App\Http\Controllers;

// import models
use App\Models\Roles;

use App\Helpers\Http;
use App\Helpers\Constantes;
use App\Helpers\LogHelper;

// import for create pfds
//use Crabbly\Fpdf\Fpdf;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

// header and footer for institutional templates
// use App\Helpers\PlantillaHelper;
// for storage pdf temp files
use Illuminate\Support\Facades\Storage;


use Validator;

class RolController extends Controller
{
    /**
     * Display a listing of the resource Roles
     */

    private $prefix_rol = "ROLE_";


    /**
     *
     *  @OA\Get(path="/roles/list",
     *     tags={"Roles"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos los roles registrados en la tabla: ds_roles.",
     *     summary="Lista todos los roles",
     *     operationId="rolesList",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el listado de Roles",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(
     *                  property="datos",
     *                  description="Datos del resultado de la api",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property ="id",type="integer",description="Id del rol"),
     *                      @OA\Property(property ="rol_nombre",type="string",description="Nombre del rol"),
     *                      @OA\Property(property ="rol",type="string",description="Nombre del rol strtolower"),
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
        // get data using elocuent
        $roles = Roles::all();

        if (!$roles) {
            return Http::respuesta(Http::retError, $roles);
        }
        return Http::respuesta(Http::retOK, $roles);
    }

    /**
     * Display the specified resource by id Rol
     */

     /**
     *
     *  @OA\Get(path="/roles/findbyid/{id}",
     *     tags={"Roles"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Devuelve todos datos de un rol específico encontrado por su id, los datos ocultos no son devueltos.",
     *     summary="Muestra los datos de un rol específico encontrado por su id",
     *     operationId="rolesFindById",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del rol",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Retorna la información de un rol específico",
     *         @OA\JsonContent(
     *              @OA\Property(property ="resultado",type="string",description="Estado de resultado"),
     *              @OA\Property(
     *                  property="datos",
     *                  description="Datos del resultado de la api",
     *                  type="array",
     *                  @OA\Items(
     *                      @OA\Property(property ="id",type="integer",description="Id de rol"),
     *                      @OA\Property(property ="rol_nombre",type="string",description="Nombre del rol"),
     *                      @OA\Property(property ="rol",type="string",description="Nombre del rol strtolower"),
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

    public function show($id)
    {
        $rol = Roles::find($id);

        if (!$rol) {

            return Http::respuesta(Http::retError, "Resource Roles not found");
        }
        // return json with information of resource id
        return Http::respuesta(Http::retOK, $rol);
    }

    /**
     * Store a newly created resource in storage
     */

    /**
     *
     *  @OA\Post(path="/roles/create",
     *     tags={"Roles"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Crea un rol nuevo. Al nombre enviado se le antepone la palabra ROLE automáticamente al momento de guardarse.",
     *     summary="Crea un nuevo rol",
     *     operationId="rolesCreate",
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
     *          description="Datos de nuevo rol",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required ={"rol_nombre"},
     *                  @OA\Property(
     *                      property="rol_nombre",
     *                      description="Nombre del rol",
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
            'rol_nombre' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        /**
        * Log ALERT
        */
        LogHelper::alert('Se inició proceso de creación de rol, nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);

        $rol = new Roles();

        // set prefix ROLE
        $rol_name = $this->prefix_rol . "" . strtoupper($request->rol_nombre);


        $flag = Roles::where('rol_nombre', $rol_name)->get()->first();

        if($flag){
            return Http::respuesta(Http::retError, "Resource Role $rol_name already exist!");
        }

        // set field values ​​submitted from form
        $rol->rol_nombre = $rol_name;

        // save data resource in storage
        $rol->save();

        /**
        * Log ALERT
        */
        LogHelper::alert('Rol creado correctamente (nombre: '.$rol_name.'), nombre usuario responsable: '.$usuario->nombre.', usuario: '.$usuario->usuario);

        // send confirm message save data
        return Http::respuesta(Http::retOK, $rol);
    }

    /**
     * Update the specified resource in storage
     * this method is used for disable resource status
     */

    /**
     *
     *  @OA\Put(path="/roles/update/{id}",
     *     tags={"Roles"},
     *     security={
     *          {"token": {}},
     *     },
     *     description="Actualiza la data de un rol específico que se identifica por su id.",
     *     summary="Actualiza la data del rol",
     *     operationId="rolesUpdate",
     *     @OA\Response(
     *         response="200",
     *         description="Retorna el rol que ha sido modificado",
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
     *          description="Datos del rol a modificar.",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required ={"rol_nombre"},
     *                  @OA\Property(
     *                      property="rol_nombre",
     *                      description="Nombre nuevo del rol",
     *                      type="string"
     *                  ),
     *              )
     *          )
     *      ),
     *      @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID del rol a modificar",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *
     *  )
     *
     */

    public function update(Request $request, $id)
    {

        // find afp resource for id
        $rol = Roles::find($id);

        if (!$rol) {

            return Http::respuesta(Http::retError, "Resource Roles $id not found");
        }

        $validator = Validator::make($request->all(), [
            'rol_nombre' => 'required|unique:ds_roles,rol_nombre,' . $id,

        ]);
        if ($validator->fails()) {
            return $validator->errors();
        }

        // set pfrefix ROLE
        $rol_name = $this->prefix_rol . "" . strtoupper($request->rol_nombre);
        // set field values ​​submitted from form
        $rol->rol_nombre = $rol_name;


        // save data resource in storage
        $rol->save();

        // send confirm message save data
        return Http::respuesta(Http::retOK, $rol);
    }
    /**
     * Export Pdf List Roles
     */


    public function ExportPdf()
    {


        $pdf = new PlantillaHelper();
        $pdf->AliasNbPages();

        $afps = Roles::all();

        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Listado de Roles', 0, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(25, 10, 'Id', 1, 0, 'L', 0);
        $pdf->Cell(90, 10, 'Nombre', 1, 0, 'C', 0);

        $pdf->Ln();

        foreach ($afps as $datos) {

            $pdf->Cell(25, 10, $datos['id'], 1, 0, 'L', 0);
            $pdf->Cell(90, 10, $datos['rol_nombre'], 1, 0, 'L', 0);
            $pdf->Ln();
        }

        // reverso
        $pdf->AddPage();
        $pdf->SetFillColor(49, 57, 69);
        $pdf->Rect(0, 0, 215.9, 279.4, 'F');
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, strtoupper('ministerio de salud'), 0, 0, 'C');

        // force download file
        $fileName = "roles_" . date('dmy_Hms') . ".pdf";
        Storage::put($pdf->Output($fileName, 'I'));
    }



    public function existsRole($roleName){
        $flag = false;
        $roles = Roles::where('rol_nombre',[$roleName])
                    ->get();

        if(count($roles) > 0){
            $flag = true;
        }
        return $flag;

    }
}
