<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Http
{

    const retOK = 'OK';
    const retError = "ERROR";
    const retDenyBot = "BOT";
    const retNotFound = "NOTFOUND";

    public static function respuesta($resultado, $datos, $cache = false): \Illuminate\Http\JsonResponse
    {
        $codigo = 200;
        if (is_null($resultado)){
            $resultado = empty($datos) ? self::retError : self::retOK;
        }

        if ($resultado === self::retError) {
            $codigo = 200;
        }

        $response = response()->json([
            'resultado' => $resultado,
            'datos' => $datos,
            'entregado' => date('Y-m-d H:i:s e'),
            'consumo' => round(microtime(true) - APP_START_TIME, 2),
        ], $codigo);

        if ($cache) {
            $response->header('Cache-Control', 'max-age=600, public');
        } else {
            $response->header('Cache-Control', 'no-store');
        }

        return $response;
    }

    public static function codigo($codigo, $datos): \Illuminate\Http\JsonResponse
    {
        $response = response()->json([
            'resultado' => $codigo,
            'datos' => $datos,
            'entregado' => date('Y-m-d H:i:s e'),
            'consumo' => round(microtime(true) - APP_START_TIME, 2),
        ], $codigo);


        return $response;
    }

}
