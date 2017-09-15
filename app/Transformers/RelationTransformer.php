<?php

namespace App\Transformers;

class RelationTransformer
{
    public function transformItem($item_name, $item, $related_name, $related)
    {
        return [
            'data' => array(
                'type' => $related_name,
                'id' => $item->{$related_name}->id
            ),
            'links' => array(
                'self' => url('/api/'.$item_name.'/'.$item->id.'/relationships/'.$related_name),
                'related' => url('/api/'.$item_name.'/'.$item->id.'/'.$related_name)
            )
        ];
    }

    public function transformCollection($item, $item_name, $related, $related_name)
    {
        return [
            'data' => array(
                'type' => $key,
                'id' => $item->{$key}->id
            ),
            'links' => array(
                'self' => url('/api/'.$item_name.'/'.$item->id.'/relationships/'.$related_name),
                'related' => url('/api/'.$item_name.'/'.$item->id.'/'.$related_name)
            )
        ];
    }
}
