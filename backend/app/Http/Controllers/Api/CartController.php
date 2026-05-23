<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\AddItemCartRequest;

use App\Models\ItemCart;
use App\Models\Product;
use App\Models\ShoppingCart;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = ShoppingCart::with([
            'items.product'
        ])
            ->firstOrCreate([
                'user_id' => $request->user()->id
            ]);

        $subtotal = $cart->items->sum(function ($item) {

            return $item->amount * $item->unit_price;
        });

        return response()->json([

            'success' => true,

            'data' => [

                'cart_id' => $cart->id,

                'items' => $cart->items,

                'subtotal' => $subtotal

            ]

        ]);
    }

    public function store(AddItemCartRequest $request)
    {
        $cart = ShoppingCart::firstOrCreate([

            'user_id' => $request->user()->id
        ]);

        $product = Product::findOrFail(
            $request->product_id
        );

        // =====================================
        // Verifica se produto já existe

        $item = ItemCart::where([

            'cart_id' => $cart->id,

            'product_id' => $product->id

        ])->first();

        // =====================================
        // Incrementa quantidade

        if ($item) {

            $item->amount += $request->quantity;

            $item->save();
        }

        // =====================================
        // Novo item

        else {

            $item = ItemCart::create([

                'cart_id' => $cart->id,

                'product_id' => $product->id,

                'amount' => $request->quantity,

                'unit_price' => $product->price
            ]);
        }

        return response()->json([

            'success' => true,

            'message' => 'Produto adicionado ao carrinho',

            'data' => $item

        ], 201);
    }

    public function update(
        Request $request,
        ItemCart $item
    ) {

        $request->validate([

            'amount' => [
                'required',
                'integer',
                'min:1'
            ]

        ]);

        $item->update([

            'amount' => $request->amount
        ]);

        return response()->json([

            'success' => true,

            'message' => 'Quantidade atualizada',

            'data' => $item

        ]);
    }

    public function destroy(ItemCart $item)
    {
        $item->delete();

        return response()->json([

            'success' => true,

            'message' => 'Item removido do carrinho'

        ]);
    }

    public function clear(Request $request)
    {
        $cart = ShoppingCart::where(
            'user_id',
            $request->user()->id
        )->first();

        if ($cart) {

            $cart->items()->delete();
        }

        return response()->json([

            'success' => true,

            'message' => 'Carrinho limpo'

        ]);
    }
}
