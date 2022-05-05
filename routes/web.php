<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Http\Controllers\RolController;
use Illuminate\Support\Facades\Request;
use OpenApi\Tests\Fixtures\StaticAnalyser\routes;

$router->get('/', function () use ($router) {
    return 'API OK';
});

$router->get('/ip', function () use ($router) {
    return date('Y-m-d H:i:s e') . ' - ' . Request::ip();
});

$router->get('/ipx', function () use ($router) {
    print_r($_SERVER['HTTP_X_FORWARDED_FOR']);
});


/*
|--------------------------------------------------------------------------
| Autenticar
|--------------------------------------------------------------------------
*/
$router->group(['prefix' => '/api'], function () use ($router) {
    $router->post('autenticar', 'AuthController@autenticar');
    $router->post('cerrar-sesion', 'AuthController@salir');
    $router->post('refrescar', 'AuthController@refrescar');
    //'AuthController@refrescar');
});


/*
|--------------------------------------------------------------------------
| Roles
|--------------------------------------------------------------------------
*
* Group prefix (roles) and protected zone with middleware AuthController
*
*/
$router->group(['prefix' => '/roles', 'middleware' => 'Auth'], function () use ($router) {

    $router->get('list', 'RolController@index');
    $router->get('findbyid/{id}', 'RolController@show');
    $router->post('create', 'RolController@store');
    $router->put('update/{id}', 'RolController@update');
});


/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
$router->get('usuarios/list',  ['middleware' => 'Auth', 'uses' => 'UsuarioController@index']);
$router->get('usuarios/me', ['middleware' => 'Auth', 'uses' => 'UsuarioController@me']);
$router->get('usuarios/findbyid/{id_usuario}', ['middleware' => 'Auth', 'uses' => 'UsuarioController@findByIdUsuario']);
$router->post('usuarios/create',  ['middleware' => 'Auth', 'uses' => 'UsuarioController@store']);
$router->put('usuarios/update', ['middleware' => 'Auth', 'uses' => 'UsuarioController@update']);
$router->get('usuarios/findByIdInstitucion/{id_institucion}',  ['middleware' => 'Auth', 'uses' => 'CatalogoController@getUsuariosByIdInstitucion']);
$router->get('/usuarios/findbynickname/{nickname}',  ['middleware' => 'Auth', 'uses' => 'UsuarioController@findByNickname']);


/*
|--------------------------------------------------------------------------
| Instituciones
|--------------------------------------------------------------------------
*/
$router->get('instituciones/list',  ['middleware' => 'Auth', 'uses' => 'CatalogoController@getInstituciones']);

