<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use \App\Models\Fornecedor;

class FornecedoresController extends BaseController
{
    /**
     * Retorna a listagem de um registros.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Fornecedor::all();
        return $this->sendResponse($resources->toArray(), 'Fornecedores retornados com sucesso.');
    }

    /**
     * Retorna um registro específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resource = Fornecedor::find($id);

        if (is_empty($resource)) {
            return $this->sendError('Fornecedor não encontrado.');
        }

        return $this->sendResponse($resource->toArray(), 'Fornecedor obtido com sucesso.');
    }

    /**
     * Armazena um registro recém criado no banco.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nome_fantasia' => 'required',
            'razao_social' => 'required',
            'cnpj' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $resource = Fornecedor::create($input);

        return $this->sendResponse($resource->toArray(), 'Fornecedor criado com sucesso.');
    }

    /**
     * Atualiza um registro específico no banco.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fornecedor $fornecedor)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nome_fantasia' => 'required',
            'razao_social' => 'required',
            'cnpj' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Erro de validação.', $validator->errors());       
        }

        $fornecedor->nome_fantasia = $input['nome_fantasia'];
        $fornecedor->razao_social = $input['razao_social'];
        $fornecedor->cnpj = $input['cnpj'];
        $fornecedor->save();

        return $this->sendResponse($fornecedor->toArray(), 'Fornecedor atualizado com sucesso.');
    }

    /**
     * Exclui um registro específico do banco.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();

        return $this->sendResponse($fornecedor->toArray(), 'Fornecedor excluído com sucesso.');
    }
}
