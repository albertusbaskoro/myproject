<?php

namespace App\Transformers;

use App\Models\Meal;
use League\Fractal\TransformerAbstract;

class MealTransformer extends TransformerAbstract
{
    protected $availableIncludes  = ['cook', 'category', 'owner', 'description'];
    protected $defaultIncludes  = ['category'];

    public function transform(Meal $meal)
    {
        $meal->category = ($meal->category) ? $meal->category : null;
        $meal->cook = ($meal->cook) ? $meal->cook : null;
        return $meal->toArray();
    }

    public function includeCategory(Meal $meal)
    {
        return ($meal->category) ? $this->item($meal->category, new CategoryTransformer, 'category') : null;
    }

    public function includeOwner(Meal $meal)
    {
        return ($meal->owner) ? $this->item($meal->owner, new UserTransformer, 'user') : null;
    }
}
