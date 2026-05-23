<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\CheckoutRequest;

use App\Models\ItemOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ShoppingCart;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(CheckoutRequest $request)
    {
        DB::beginTransaction();
        try {

            $cart = ShoppingCart::with([
                'items.product'
            ])
            ->where(
                'user_id',
                $request->user()->id
            )
            ->first();

            if (!$cart || $cart->items->isEmpty()) {

                return response()->json([

                    'success' => false,

                    'message' => 'Carrinho vazio'

                ], 400);
            }

            $subtotal = $cart->items->sum(function ($item) {

                return (
                    $item->amount
                    * $item->unit_price
                );
            });

            $freight = 20;

            $discount = 0;

            $total = (
                $subtotal
                + $freight
                - $discount
            );

            $order = Order::create([

                'user_id' => $request->user()->id,

                'subtotal' => $subtotal,

                'discount' => $discount,

                'freight' => $freight,

                'total' => $total,

                'type_delivery' => $request->type_delivery,

                'status_order' => 'pendente'
            ]);

            foreach ($cart->items as $item) {

                ItemOrder::create([

                    'order_id' => $order->id,

                    'product_id' => $item->product_id,

                    'amount' => $item->amount,

                    'unit_price' => $item->unit_price,

                    'subtotal_item' => (
                        $item->amount
                        * $item->unit_price
                    )
                ]);
            }

            Payment::create([

                'order_id' => $order->id,

                'type_payment' => $request->type_payment,

                'value' => $total,

                'status_order' => 'pendente',

                'data_payment' => now()
            ]);

            $cart->items()->delete();

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Pedido criado com sucesso',

                'data' => $order->load([
                    'items.product',
                    'payment'
                ])

            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 500);
        }
    }

    public function index(Request $request)
    {
        $orders = Order::with([
            'items.product',
            'payment'
        ])
        ->where(
            'user_id',
            $request->user()->id
        )
        ->latest()
        ->paginate(10);

        return response()->json([

            'success' => true,

            'data' => $orders

        ]);
    }

    public function show(Order $order)
    {
        $order->load([
            'items.product',
            'payment'
        ]);

        return response()->json([

            'success' => true,

            'data' => $order

        ]);
    }
}