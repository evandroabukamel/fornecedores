<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    /**
     * Register API
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'c_password' => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Erro de validação.', $validator->errors());       
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('CentralFornecedores')->accessToken;
            $success['name'] =  $user->name;

            return $this->sendResponse($success, 'Usuário registrado com sucesso.');
        }
        catch (\Illuminate\Database\QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == '1062') {
                return $this->sendError('Esse e-mail já está cadastrado para um usuário.');
            }
            else {
                return $this->sendError('Houve alguma falha inesperada de banco de dados.');
            }
        }
        catch (\Exception $e) {
            return $this->sendError('Ocorreu alguma falha inesperada durante o cadastro.');
        }
    }
}