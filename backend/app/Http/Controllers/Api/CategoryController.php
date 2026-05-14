<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Http\Resources\CategoryResource;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->latest()
            ->paginate(10);

        return response()->json([

            'success' => true,

            'data' => CategoryResource::collection($categories)

        ]);
    }

    public function show(Category $category)
    {
        $category->loadCount('products');

        return response()->json([

            'success' => true,

            'data' => new CategoryResource($category)

        ]);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create(
            $request->validated()
        );

        return response()->json([

            'success' => true,

            'message' => 'Categoria criada com sucesso',

            'data' => new CategoryResource($category)

        ], 201);
    }

    public function update(
        UpdateCategoryRequest $request,
        Category $category
    ) {

        $category->update(
            $request->validated()
        );

        return response()->json([

            'success' => true,

            'message' => 'Categoria atualizada',

            'data' => new CategoryResource($category)

        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([

            'success' => true,

            'message' => 'Categoria removida'

        ]);
    }
}