<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'category',
            'sizes'
        ])->paginate(10);

        return response()->json([
            'success' => true,

            'data' => $products
        ]);
    }

    public function show(Product $product)
    {
        $product->load([
            'category',
            'sizes'
        ]);

        return response()->json([
            'success' => true,

            'data' => $product
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],

            'description' => ['required'],

            'price' => ['required', 'numeric'],

            'stock' => ['required', 'integer'],

            'category_id' => [
                'required',
                'exists:categories,id'
            ]
        ]);

        $product = Product::create([
            'name' => $request->name,

            'description' => $request->description,

            'price' => $request->price,

            'stock' => $request->stock,

            'category_id' => $request->category_id
        ]);

        return response()->json([
            'success' => true,

            'message' => 'Produto criado com sucesso',

            'data' => $product
        ], 201);
    }

    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([
            'name' => ['sometimes'],

            'description' => ['sometimes'],

            'price' => ['sometimes', 'numeric'],

            'stock' => ['sometimes', 'integer']
        ]);

        $product->update($request->all());

        return response()->json([
            'success' => true,

            'message' => 'Produto atualizado',

            'data' => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,

            'message' => 'Produto removido'
        ]);
    }
}