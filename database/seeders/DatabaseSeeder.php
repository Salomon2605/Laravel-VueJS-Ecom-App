<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(10) //creer 10 users
            ->has( //avec le has, chaque user aura 3 orders
                Order::factory()
                    ->count(3) 
                    ->hasAttached( //et avec le hasAttached qu'on utilise quand on a une relation many to many (ce qui est le cas entre orders et products)
                        Product::factory()->count(5), //et on aura 5 produits par commande 
                        ['total_price' => rand(100, 500), 'total_quantity' => rand(1,3)]
                    )
            )
            ->create();
    }
}
