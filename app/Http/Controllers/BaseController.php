<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

abstract class BaseController extends Controller
{

    protected $service;

    public function index()
    {
        return $this->service->all();
    }

    public function store(Request $request){
        try{
            return response()
                ->json($this->service->create($request->all()), 201);
        } catch (Exception $e){
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(int $id)
    {
        try{
            return response()
                ->json($this->service->find($id));
        } catch (Exception $e){
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function update(int $id, Request $request)
    {
        try{
            return response()
                ->json($this->service->save($id, $request));
        } catch (Exception $e){
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
    }

    public function destroy(int $id)
    {
        try{
            return response()
                ->json($this->service->destroy($id), 204);
        } catch (Exception $e){
            return response()->json(['Error' => $e->getMessage()], $e->getCode());
        }
    }
}
