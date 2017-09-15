<?php

namespace App\Transformers;

use App\Models\Side;
use League\Fractal\TransformerAbstract;

class SideTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Side $side)
    {
        return $side->toArray();
    }
}
