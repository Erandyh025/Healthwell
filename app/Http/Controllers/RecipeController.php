<?php

namespace App\Http\Controllers;

use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class RecipeController extends Controller
{
    protected $recipe_respository;

    public function __construct(RecipeRepository $repository)
    {
        $this->recipe_respository = $repository;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'prescription' => 'required|string',
            'start_date' => 'required|date',
            'ending_date' => 'required|date',

        ]);
        if ($validator->fails()) {
            Log::warning('RecipeController','create','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $uuid = Uuid::generate()->string;
        $prescription = $request->input('prescription');
        $start_date = $request->input('start_date');
        $ending_date = $request->input('ending_date');
        $inquiries_id = $request->input('inquiries_id');
        Log::info('RecipeController - create - Se creo una nueva recipe');
        return response()->json($this->recipe_respository->create($uuid, $prescription, $start_date, $ending_date, $inquiries_id));
        } catch (\Exception $ex) {
        Log::emergency('RecipeController','create','Ocurrio un error al crear una nueva receta');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function updated(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'prescription' => 'required|string',
            'start_date' => 'required|date',
            'ending_date' => 'required|date',

        ]);
        if ($validator->fails()) {
            Log::warning('RecipeController','updated','Falta un campo por llenar');
            return response()->json($validator->errors()->toJson(), 400);
        }
        try{
        $prescription = $request->input('prescription');
        $start_date = $request->input('start_date');
        $ending_date = $request->input('ending_date');
        Log::info('RecipeController - updated - Se actualizo la receta con el uuid'.$this->hospitals_respository->find($uuid));
        return response()->json($this->recipe_respository->updated($uuid, $prescription, $start_date, $ending_date));
        } catch(\Exception $ex){
        Log::emergency('RecipeController','updated','Ocurrio un error al actualizar la receta');
        return response()->json(['error' => $ex->getMessage()]);
        }
    }

    public function delete($uuid)
    {
        try{
            Log::info('RecipeController - delete - Se ha eliminado la receta');
            return response()->json($this->recipe_respository->delete($uuid));
        } catch(\Exception $ex){
            Log::emergency('RecipeController','delete','Ocurrio un error al eliminar la receta');
            return response()->json(['error' => $ex->getMessage()]);
            }
    }
    function list() {
        return response()->json($this->recipe_respository->list());
    }

    public function editar($uuid)
    {
        return response()->json($this->recipe_respository->find($uuid));
    }

}
