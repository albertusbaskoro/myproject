<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Transformers\CategoryMealTransformer;
use App\Transformers\CategoryTransformer;
use App\Transformers\MealTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Serializer\JsonApiSerializer;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'per_page' => 'integer',
            'order' => 'string|in:asc,desc',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $this->validationFails($validator->errors()),
                422
            );
        }

        $paginator = Category::activeCategory()
            ->when($request->order, function ($query) use ($request) {
                return $query->orderBy('title', $request->order);
            })
            ->paginate($request->per_page);

        $categories = $paginator->getCollection();

        return fractal()->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->collection($categories, new CategoryTransformer(), 'category')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
            ->respond();
    }

    /**
     * DEPECRATED
     * Meals by category must be in MealsController, not here
     *
     * @return \Illuminate\Http\Response
     */
    public function mealsByCategory(Category $category): JsonResponse
    {
        $paginator = $category->meals()->active()->paginate(request()->input('per_page'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;

        $category->slug = $request->slug;
        $category->title = $request->title;
        $category->save();
        var_dump($category->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return fractal()->item($category, new CategoryTransformer(), 'category')
            ->serializeWith(new JsonApiSerializer(url('/api/')))
        // ->parseIncludes(request()->input('include'))
        // ->parseInclude('includeDescription')
            ->respond();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category = Category::find();

        $category->update = $request->update;
        // $category->title = $request->name;
        // $category->status = $request->'inactive';

        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
