<?php

namespace Database\Seeders;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\ItemCart;
use App\Models\ItemOrder;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Size;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // =====================================
        // Usuário administrador fixo

        User::create([
            'name' => 'Administrador',

            'email' => 'admin@uniforstore.com',

            'password' => Hash::make('12345678'),

            'cpf' => '000.000.000-00',

            'link_type' => 'interno',

            'access_level' => 'docente',

            'active' => true
        ]);

        // =====================================
        // Usuários fake

        User::factory(20)->create();

        // =====================================
        // Tamanhos

        $sizes = [
            'PP',
            'P',
            'M',
            'G',
            'GG'
        ];

        foreach ($sizes as $size) {
            Size::create([
                'name_size' => $size
            ]);
        }

        // =====================================
        // Categorias + Produtos

        Category::factory(5)
            ->create()
            ->each(function ($category) {

                Product::factory(10)
                    ->create([
                        'category_id' => $category->id
                    ])
                    ->each(function ($product) {

                        // Relacionar tamanhos aleatórios
                        $product->sizes()->attach(
                            Size::inRandomOrder()
                                ->take(rand(1, 5))
                                ->pluck('id')
                        );
                    });
            });

        // =====================================
        // Cupons

        Coupon::factory(10)->create();

        // =====================================

        ShoppingCart::factory(15)
            ->create()
            ->each(function ($cart) {

                ItemCart::factory(rand(1, 5))
                    ->create([
                        'cart_id' => $cart->id,
                        'product_id' => Product::inRandomOrder()->first()->id
                    ]);
            });

        // =====================================
        // Pedidos

        Order::factory(20)
            ->create()
            ->each(function ($order) {

                ItemOrder::factory(rand(1, 5))
                    ->create([
                        'order_id' => $order->id,
                        'product_id' => Product::inRandomOrder()->first()->id
                    ]);

                Payment::factory()->create([
                    'order_id' => $order->id,
                    'value' => $order->total
                ]);
            });

        // =====================================
        // Banners

        Banner::factory(5)->create();
    }
}
