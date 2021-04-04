<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{

    protected $service;
    protected $validations = null;

    public function index()
    {
        return $this->service->all();
    }

    public function store(Request $request){
        if(!is_null($this->validations)){
            $this->validate($request, $this->validations);
        }
        return response()
            ->json($this->service->create($request->all()), 201);
    }

    public function show(int $id)
    {
        $recurso = $this->service->find($id);

        if(is_null($recurso)){
            return response()->json('', 204);
        }

        return response()->json($recurso);

    }

    public function update(int $id, Request $request)
    {
        $recurso = $this->service->find($id);

        if(is_null($recurso)){
            return response()->json(['Erro' => 'Recurso não encontrado'], 404);
        }

        $recurso->fill($request->all());
        $recurso->save();

        return $recurso;
    }

    public function destroy(int $id)
    {
        $qtdRemoved = $this->service->destroy($id);

        if($qtdRemoved === 0 ){
            return response()->json(["Erro" => "Recurso não encontrado"], 404);
        }

        return response()->json('', 204);
    }
}
