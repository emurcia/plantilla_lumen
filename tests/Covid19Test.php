<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class Covid19Test extends TestCase
{
    public function testInicio()
    {
        $this->get('/');

        $this->assertEquals(
            'MINSAL EL SALVADOR',
            $this->response->getContent()
        );
    }

    public function testVerificar()
    {
        $structure = [
              'consumo',
              'datos' => [
                'apellido_casada',
                'canton' => [
                  'id',
                ],
                'codigo',
                'colonia' => [
                  'id',
                  'id_dep',
                  'id_mun',
                  'nombre',
                  'nombre_may',
                  'nombre_min',
                ],
                'confirmado' => [
                  'calle',
                  'casa',
                  'dui',
                  'estado',
                  'fecha_cupo',
                  'hora_cupo',
                  'id_canton',
                  'id_colonia',
                  'id_cupo',
                  'id_departamento',
                  'id_municipio',
                ],
                'dui',
                'establecimiento' => [
                  'direccion',
                  'id',
                  'nombre',
                ],
                'fecha_nacimiento',
                'foto' => [
                  'img_foto',
                  'img_url',
                ],
                'id_canton_domicilio',
                'id_colonia_domicilio',
                'id_departamento_domicilio',
                'id_establecimiento',
                'id_fase',
                'id_municipio_domicilio',
                'id_pais_domicilio',
                'municipio' => [
                  'abreviatura',
                  'departamento' => [
                    'abreviatura',
                    'id',
                    'id_pais',
                    'nombre',
                  ],
                  'id',
                  'id_departamento',
                  'nombre',
                ],
                'pais' => [
                  'dominio2',
                  'dominio3',
                  'id',
                  'nombre',
                ],
                'primer_apellido',
                'primer_nombre',
                'revision' => [
                  'estado',
                  'id',
                ],
                'segundo_apellido',
                'segundo_nombre',
                'tercer_nombre',
                'tipo_doc',
                'version',
              ],
              'entregado',
              'resultado',
        ];

        $this->json('GET','/verificar/03890844-4/1988-02-08');

        $this->seeStatusCode(200);

        $this->seeJsonStructure($structure);
    }
}
