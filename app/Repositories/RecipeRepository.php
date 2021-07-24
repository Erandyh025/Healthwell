<?php

namespace App\Repositories;

use App\Models\Recipe;

class RecipeRepository
{
    public function create($uuid, $prescription, $start_date, $ending_date, $inquiries_id)
    {
        $data['uuid'] = $uuid;
        $data['prescription'] = $prescription;
        $data['start_date'] = $start_date;
        $data['ending_date'] = $ending_date;
        $data['inquiries_id'] = $inquiries_id;

        return recipe::create($data);

    }

    public function updated($uuid, $prescription, $start_date, $ending_date)
    {
        $recipe = $this->find($uuid);
        $recipe->prescription = $prescription;
        $recipe->start_date = $start_date;
        $recipe->ending_date = $ending_date;
        $recipe->save();
        return $recipe;

    }

    public function delete($uuid)
    {
        $recipe = $this->find($uuid);
        return $recipe->delete();
    }
    public function find($uuid)
    {
        return Recipe::where('uuid', '=', $uuid)->first();
    }
    function list() {
        $recipe = Recipe::with('inquiries')->get();
        return $recipe->toArray();
    }
}
