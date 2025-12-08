<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->info('Нет товаров для создания заказов. Сначала создайте товары.');
            return;
        }

        // Создаем 5 тестовых заказов
        for ($i = 1; $i <= 5; $i++) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'customer_name' => "Клиент $i",
                'customer_email' => "client{$i}@example.com",
                'customer_phone' => "+7 (999) 111-22-{$i}{$i}",
                'customer_address' => "ул. Тестовая, д. $i, кв. {$i}",
                'status' => $this->getRandomStatus(),
                'total_amount' => 0
            ]);

            $totalAmount = 0;
            $numItems = rand(1, 3);

            for ($j = 0; $j < $numItems; $j++) {
                $product = $products->random();
                $quantity = rand(1, 3);
                $subtotal = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);

                $totalAmount += $subtotal;
            }

            $order->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('Создано 5 тестовых заказов.');
    }

    private function getRandomStatus(): string
    {
        $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        return $statuses[array_rand($statuses)];
    }
}
