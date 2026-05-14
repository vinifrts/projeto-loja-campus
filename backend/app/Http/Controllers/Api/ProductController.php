<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'sizes'
        ]);

        if ($request->filled('search')) {

            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {

            $query->where(
                'category_id',
                $request->category
            );
        }

        if ($request->filled('min_price')) {
            $query->where(
                'price',
                '>=',
                $request->min_price
            );
        }

        if ($request->filled('max_price')) {
            $query->where(
                'price',
                '<=',
                $request->max_price
            );
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(10);

        return response()->json([
            'success' => true,
            'filters' => [
                'search' => $request->search,
                'category' => $request->category,
                'min_price' => $request->min_price,
                'max_price' => $request->max_price,
                'sort' => $request->sort
            ],

            'data' => ProductResource::collection($products)

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

            'data' => new ProductResource($product)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => ['required'],

            'description_short' => [
                'required',
                'string',
                'max:255'
            ],

            'description_long' => [
                'required',
                'string'
            ],

            'price' => ['required', 'numeric'],

            'stock' => ['required', 'integer'],

            'image' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'category_id' => [
                'required',
                'exists:categories,id'
            ]
        ]);

        $data = $request->all();

        // Upload imagem
        if ($request->hasFile('image')) {

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,

            'message' => 'Produto criado com sucesso',

            'data' => new ProductResource($product)
        ], 201);
    }

    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([

            'name' => ['sometimes'],

            'description_short' => [
                'sometimes',
                'string',
                'max:255'
            ],

            'description_long' => [
                'sometimes',
                'string'
            ],

            'price' => ['sometimes', 'numeric'],

            'image' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            'stock' => ['sometimes', 'integer']
        ]);

        $data = $request->all();
        if ($request->hasFile('image')) {
            if ($product->image) {

                Storage::disk('public')
                    ->delete($product->image);
            }

            $data['image'] = $request
                ->file('image')
                ->store('products', 'public');
        }

        $product->update($data);

        return response()->json([
            'success' => true,

            'message' => 'Produto atualizado',

            'data' => new ProductResource($product)
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
