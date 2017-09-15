<?php

namespace App\Transformers;

use App\Models\CategoryMeal;
use League\Fractal\TransformerAbstract;

class CategoryMealTransformer extends TransformerAbstract
{
    protected $defaultIncludes  = ['meal'];

    public function transform(CategoryMeal $meal)
    {
        return $meal->toArray();
    }

    public function includeMeal(CategoryMeal $meal)
    {
        return ($meal->meal) ? $this->item($meal->meal, new MealTransformer, 'meal') : null;
    }
}
