<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Cook;
use App\Transformers\CookTransformer;
use App\Transformers\MealTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Validator;

class CookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = Cook::active()->paginate(request()->input('per_page'));
        $cooks = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($cooks, new CookTransformer(), 'cook')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->respond();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function mealsCookById($id)
    {
        $cook = Cook::IdScope($id)->firstOrFail();
        $paginator = $cook->meal()->activeMeal()->paginate(request()->input('per_page'));
        $meals = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($meals, new MealTransformer(), 'meal')
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

    }

    /**
     * Register as new cook.
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|max:20',
            'address' => 'required',
            'about' => 'required',
            'meals' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $cook = Cook::create([
            'fullname' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'meals' => $request->meals,
        ]);

        return response()->json([
            'status' => true,
            'code' => 200,
            'data' => [
                'id' => $cook->id,
                'attributes' => $cook,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cook  $cook
     * @return \Illuminate\Http\Response
     */
    public function show(Cook $cook)
    {
        return fractal()->item($cook, new CookTransformer(), 'cook')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->parseIncludes(request()->input('include'))
            ->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cook  $cook
     * @return \Illuminate\Http\Response
     */
    public function edit(Cook $cook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cook  $cook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cook $cook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cook  $cook
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cook $cook)
    {
        //
    }
}
