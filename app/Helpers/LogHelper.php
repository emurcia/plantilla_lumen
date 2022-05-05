<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    public static function info($message) {
        Log::info($message, self::getContext());
    }

    public static function alert($message) {
        Log::alert($message, self::getContext());
    }

    public static function error($message) {
        Log::error($message, self::getContext());
    }
    
    public static function warning($message) {
        Log::warning($message, self::getContext());
    }

    public static function debug($message) {
        Log::debug($message, self::getContext());
    }

    private static function getContext() {
        if (Auth::guest()) {
            return ['UID' => 0, 'EID' => 0];
        } else {
            $usuario = Auth::user();
            return [
                'UID' => $usuario->id,
                'UNOM' => $usuario->nombre,
                //'EID' => $usuario->establecimiento->id,
                //'ENOM' => $usuario->establecimiento->nombre,
            ];
        }
    }
}