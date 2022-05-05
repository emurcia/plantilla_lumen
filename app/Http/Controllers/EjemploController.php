<?php

namespace App\Http\Controllers;

use App\Helpers\Http;
use App\Helpers\LogHelper;
use App\Helpers\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Usuario;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Validator;

class EjemploController extends Controller
{

    public function ejemplo($id = 1)
    {
        return Http::respuesta(Http::retOK, ['ejemplo' => $id]);
    }


    public function generateQRCodigo()
    {

        $data = Institucion::where('id', 1)->get();



        //  Presición L = Baja, M = Mediana, Q = Alta, H= Máxima

        $options = new QROptions([
            'version' => QRCode::VERSION_AUTO,
            'outputType' => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel' => QRCode::ECC_L,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'imageBase64' => false
        ]);

        echo '<img src="' . (new QRCode())->render($data) . '" />';
        exit;
    }

}
