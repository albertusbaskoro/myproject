<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryMeal;
use App\Models\Meal;
use App\Transformers\MealTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Validator;

class MealController extends Controller
{
    public function category(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $paginator = $category->meal()
            ->paginate($request->has('per_page') ? $request->per_page : 20);

        $meals = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($meals, new MealTransformer(), 'meal')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->respond();
    }

    /**
     * Filter meals based on cook.
     *
     * @param  integer $id
     * @return JsonResponse
     */
    public function cook(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $meals = Meal::whereHas('cook', function ($cook) use ($id) {
            return $cook->where('id', $id);
        })
            ->paginate($request->has('per_page') ? $request->per_page : 20);

        $collection = $meals->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($meals))
            ->collection($collection, new MealTransformer, 'meal')
            ->serializeWith(new JsonApiSerializer(url('/api')))
            ->respond();
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $paginator = Meal::activeMeal()->paginate($request->per_page);
        $meals = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($meals, new MealTransformer(), 'meal')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->respond();
    }
    /**
     * Show favorites meals.
     *
     * @return JsonResponse
     */
    public function favorite(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails(), 422);
        }

        $paginator = Meal::activeMeal()->favorite()->paginate($request->per_page);
        $meals = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($meals, new MealTransformer(), 'meal')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->respond();
    }
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string',
            'per_page' => 'integer',
        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $paginator = Meal::activeMeal()
            ->when($request->title, function ($query) use ($request) {
                return $query->like($request->title);
            })
            ->paginate($request->per_page);

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            return response()->json($this->validationFails($validator->errors()), 422);
        }

        $meal = new Meal;

        $meal->slug = $request->slug;
        $meal->save();

        // return "insertd db";
        return Response::json([
            'success' => true,
            'code' => 200,
            'meal' => $meal,
            'links' => [
                'self' => route('meals.show', $meal->id),
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        return fractal()->item($meal, new MealTransformer(), 'meal')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->parseIncludes(request()->input('include'))
            ->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
