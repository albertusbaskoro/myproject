<?php

namespace App\Transformers;

use App\Models\Orderitem;
use League\Fractal\TransformerAbstract;

class OrderitemTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform()
    {
       public function transform(Orderitem $Orderitem)
    {
        return $Orderitem->toArray();
    }
    }
}
