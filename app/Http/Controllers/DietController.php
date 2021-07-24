<?php

namespace App\Http\Controllers;

use App\Models\allowed_foods;
use App\Models\Bread_and_sustitute;
use App\Models\forbidden_foods;

use Uuid;
use App\Shared\LogManage;
use Illuminate\Support\Facades\Log;

class DietController extends Controller
{

    public function delete($uuid)
    {
        try{
        $allowed = allowed_foods::where('uuid', '=', $uuid)->first();
        $allowed->allowed->delete();
        $allowed->delete();

        $forbidden = forbidden_foods::where('uuid', '=', $uuid)->first();
        $forbidden->forbidden->delete();
        $forbidden->delete();

        $bread = Bread_and_sustitute::where('uuid', '=', $uuid)->first();
        $bread->bread->delete();
        $bread->delete();

        Log::info('DietController - delete - Se ha eliminado la dieta');
        return response()->json('Datos eliminados');
            } catch(\Exception $ex){
        Log::emergency('DietController','delete','Ocurrio un error al intentar eliminar una dieta');
        return response()->json(['error' => $ex->getMessage()]);
        }

    }
}
