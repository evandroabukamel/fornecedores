<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome', [
        'name' => 'World'
    ]);
});

/*Route::get('fornecedores', function () {
    $fornecedores = DB::table('fornecedores')->get();
    return view('fornecedores', compact('fornecedores'));
});*/

//Route::get('fornecedores', 'API\FornecedoresController@index');
//Route::get('fornecedores/{fornecedor}', 'API\FornecedoresController@show');