<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

class Constantes
{
    /*
    * Ejemplos:
    const fecha_limite_agendamiento = '2021-05-22';
    const array_fases_activas = [];
    const img_url_server = 'https://minsal-fotos.s3.amazonaws.com';
    const dias_flexibilidad_2da_dosis = 4;
    */

    const INSTITUCION = 'MINISTERIO DE SALUD';
    const TIPO_VISITANTE = 'VISITANTE';

    const MSG_EXTRAVIO = 'En caso de extravío de este Gafete, usted cancelará $3.00 Dólares, en concepto de Reposición.';
    const MSG_ERROR_PDF = "Error al Generar PDF, parámetros inválidos";
    const COLOR_RGBVISITANTE = array(17, 31, 96);

    // SIZE for ID users Landscape orientation
    const WIDTH_HORIZONTAL = 86;
    const HEIGHT_HORIZONTAL = 55;

    // SIZE for ID User Portrait Orientation

    //const WIDTH_PORTRAIT=60;
    //const HEIGHT_PORTRAIT=100;

    const WIDTH_PORTRAIT = 55;
    const HEIGHT_PORTRAIT = 86;


    // CARNÉ SEGURIDAD
    const CARNE_TSEGURIDAD = 'PERSONAL';
    const CARNE_TSEGURIDADSUB = 'DE SEGURIDAD';
    const COLOR_RGBSEGURIDAD = array(17, 31, 96);

    // CARNÉ EMPLEADOS
    const COLOR_RGBEMPLOYEE = array(49, 57, 69);
    const FILL_TOP_EMPLOYEE = 27;

    const CASO_EMERGENCIA = "En caso de emergencia llamar a";
}