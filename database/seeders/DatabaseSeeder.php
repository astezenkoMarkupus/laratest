<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderStatuses;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(100)->create();
        Product::factory(100)->create();
		OrderStatuses::factory(5)->create();
        Order::factory(100)->create()->each(function (Order $order) {
			$order->products()->attach([rand(1, 100), rand(1, 100)]);
        });
    }
}
