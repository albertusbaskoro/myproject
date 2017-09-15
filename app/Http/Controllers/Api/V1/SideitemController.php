<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Sideitem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Validator;
use DB;


class SideitemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * Store a list of sideitem
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = Input::all(); 
        DB::table('sideitem')->insert($data);

        if ($data != NULL) {
            return response(array('success' => true, 'code' => 200, 'message' => 'data inserted to sideitem', 'data' => $data), 200);
        } else {
            return response(array('success' => false, 'code' => 500, 'message' => 'data not falid', 'data' => ''), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sideitem  $sideitem
     * @return \Illuminate\Http\Response
     */
    public function show(Sideitem $sideitem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sideitem  $sideitem
     * @return \Illuminate\Http\Response
     */
    public function edit(Sideitem $sideitem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sideitem  $sideitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sideitem $sideitem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sideitem  $sideitem
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sideitem $sideitem)
    {
        //
    }
}
