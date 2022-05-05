<?php

use App\Helpers\Constantes;
use App\Helpers\VacunacionHelper;
use Carbon\Carbon;

class VacunacionHelperTest extends TestCase
{
    public function testHanPasadoDiasEntreDosisExacto()
    {
        $fecha_hora =  Carbon::now()->subDays(20);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosis($fecha_hora, 20));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisSobrepasado()
    {
        $fecha_hora =  Carbon::now()->subDays(30);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosis($fecha_hora, 20));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisMismoDia()
    {
        $fecha_hora =  Carbon::now();
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosis($fecha_hora, 20));
        print_r($resultado);
        $this->assertFalse($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisMinima()
    {
        $fecha_hora =  Carbon::now()->subDays(20 - Constantes::dias_flexibilidad_2da_dosis);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosis($fecha_hora, 20));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisSegun2daCitaExacto()
    {
        $fecha_hora =  Carbon::now();
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosisSegun2daCita($fecha_hora));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisSegun2daCitaExactoSobrepasado()
    {
        $fecha_hora =  Carbon::now()->addDays(30);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosisSegun2daCita($fecha_hora));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisSegun2daCitaMinima()
    {
        $fecha_hora =  Carbon::now()->subDays(Constantes::dias_flexibilidad_2da_dosis);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosisSegun2daCita($fecha_hora));
        print_r($resultado);
        $this->assertTrue($resultado['aplicable']);
    }

    public function testHanPasadoDiasEntreDosisSegun2daCitaMuyAntes()
    {
        $fecha_hora =  Carbon::now()->subDays(Constantes::dias_flexibilidad_2da_dosis + 1);
        $resultado = (VacunacionHelper::hanPasadoDiasEntreDosisSegun2daCita($fecha_hora));
        print_r($resultado);
        $this->assertFalse($resultado['aplicable']);
    }
}
