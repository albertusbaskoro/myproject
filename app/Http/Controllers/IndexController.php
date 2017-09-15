<?php

namespace App\Http\Controllers;

class IndexController extends Controller
{
    public function __invoke()
    {
        // just for test cache
        $minutes = \Carbon\Carbon::now()->addMinutes(60);
        $title = \Cache::remember('title', $minutes, function () {
            return config('app.name');
        });

        return response()->json([
            'links' => [
                'self' => route('index'),
            ],
            'data' => [
                'type' => 'application',
                'attributes' => [
                    'title' => $title,
                ],
            ],
        ]);
    }
}
