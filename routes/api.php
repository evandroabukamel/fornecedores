<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
    Adicione esses headers às requisições.

    'headers' => [
        'Accept' => 'application/json',
        'Authorization' => 'Bearer '.$accessToken,
    ]

    Personal access client created successfully.
    Client ID: 1
    Client Secret: 2k25K3sJiocFJ71Wd58CoIGF0NSWbvYdAVkiR2FM

    Password grant client created successfully.
    Client ID: 2
    Client Secret: vYDzo4CTaerBXYL9M498FW8ENYJc3dldJLvwqTL4

*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// App v1 API
Route::group([
    'middleware' => ['app', 'api.version:1'],
    'namespace'  => 'App\Http\Controllers\App',
    'prefix'     => 'api/v1',
], function ($router) {
    require base_path('routes/app_api.v1.php');
});

// App v2 API
/*Route::group([
    'middleware' => ['app', 'api.version:2'],
    'namespace'  => 'App\Http\Controllers\App',
    'prefix'     => 'api/v2',
 ], function ($router) {
    require base_path('routes/app_api.v2.php');
 });*/

Route::post('register', 'API\RegisterController@register');

Route::middleware('auth:api')->group( function () {
	Route::resource('fornecedores', 'API\FornecedoresController');
    Route::get('fornecedores', 'API\FornecedoresController@index');
    //Route::get('fornecedores/{fornecedor}', 'API\FornecedoresController@show');
});
