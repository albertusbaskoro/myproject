<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function validationFails($errors = [])
    {
        return [
            'status' => false,
            'code' => 422,
            'message' => 'Validation Error',
            'detail' => $errors,
            'links' => [
                'self' => request()->fullUrl(),
            ],
        ];
    }
}
