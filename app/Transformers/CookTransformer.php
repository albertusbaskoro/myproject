<?php

namespace App\Transformers;

use App\Models\Cook;
use League\Fractal\TransformerAbstract;

class CookTransformer extends TransformerAbstract
{
    public function transform(Cook $cook)
    {
        return $cook->toArray();
    }
}
