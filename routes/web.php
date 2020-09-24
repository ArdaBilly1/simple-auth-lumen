<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

// $router->get('/key', function () {
//     $char = '1234567890ABCDEFGHIJKLMNOPQRSTVWXYZabcdefgahijklmnopqrstuvwxyz';
//         $longChar = strlen($char);
//         $str = '';
//         for ($i = 0; $i < 32; $i++) {
//             $str .= $char[rand(0, $longChar - 1)];
//         }
//         return $str;
// });

$router->group(['prefix'=>'api'], function () use ($router) {
    $router->post('/login', ['uses' => 'AuthController@login']);
    $router->post('/register', ['uses' => 'AuthController@register']);
    $router->post('/lupaPass', ['uses' => 'AuthController@lupaPass']);
    
    //? API CRUD DATA ASET
    $router->get('/all/{id}', ['uses' => 'AssetController@index']);
    $router->post('/store/', ['uses' => 'AssetController@store']);
    $router->get('/store/{id}', ['uses' => 'AssetController@show']);
    $router->post('/store/{id}/{id1}', ['uses' => 'AssetController@update']);
    $router->delete('/delMhs/{id}/{id1}', ['uses' => 'AssetController@delete']);


});
