<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Orderitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\OrderitemTransformer;
use Illuminate\Support\Facades\Input;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Validator;
use DB;

class OrderitemController extends Controller
{
    /**
     * Insert Data list orderitem 
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Input::all(); 
        DB::table('orderitem')->insert($data);

        if ($data != NULL) {
            return response(array('success' => true, 'message' => 'data inserted to ordertem', 'data' => $data), 200);
        } else {
            return response(array('success' => false, 'message' => 'data not falid', 'data' => ''), 500);
        }
        
    }

    public function index()
    {
        $paginator = Orderitem::paginate(request()->input('per_page'));
        $meals = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
                        ->collection($meals, new OrderitemTransformer(), 'orderitem')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Orderitem $orderitem)
    {
        return fractal()->item($orderitem, new OrderitemTransformer(), 'orderitem')
                        ->serializeWith(new JsonApiSerializer(url('/api/')))
                        ->parseIncludes(request()->input('include'))
                        ->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
