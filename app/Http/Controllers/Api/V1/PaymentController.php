<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\PaymentTransformer;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Tymon\JWTAuth\Exceptions\JWTException;

class PaymentController extends Controller
{
    public function histroyPayment(Request $request)
    {
        $id = $request->input('_userid');
        $status = $request->input('status');

        $paginator =  Payment::history($id)->status($status)->paginate((int) request()->input('per_page'));
        $payments = $paginator->getCollection();
        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
                        ->collection($payments, new PaymentTransformer(), 'payment')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->respond();
    }
    
}
