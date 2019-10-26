<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Product;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sepatu = Category::create(['title' => 'Sepatu']);
        $sepatu->childs()->saveMany([
        	new Category(['title' => 'Lifestyle']),
        	new Category(['title' => 'Berlari']),
        	new Category(['title' => 'Basket']),
        	new Category(['title' => 'Sepakbola']),
        ]);

        $pakaian = Category::create(['title' => 'Pakaian']);
        $pakaian->childs()->saveMany([
        	new Category(['title' => 'Jaket']),
        	new Category(['title' => 'Hoodie']),
        	new Category(['title' => 'Rompi']),
        ]);

        $running = Category::where('title', 'Berlari')->first();
        $lifestyle = Category::where('title', 'Lifestyle')->first();
        $sepatu1 = Product::create([
        	'name' => 'Nike Air Force',
        	'model' => 'Sepatu Pria',
        	'photo' => 'stub-shoes.jpg',
        	'price' => 340000,
            'weight' => rand(1,3) * 1000,
        ]);

        $sepatu2 = Product::create([
        	'name' => 'Nike Air Max',
        	'model' => 'Sepatu Wanita',
        	'photo' => 'stub-shoes.jpg',
        	'price' => 420000,
            'weight' => rand(1,3) * 1000,
        ]);

        $sepatu3 = Product::create([
        	'name' => 'Nike Air Zoom',
        	'model' => 'Sepatu Wanita',
        	'photo' => 'stub-shoes.jpg',
        	'price' => 360000,
            'weight' => rand(1,3) * 1000,
        ]);

        $running->products()->saveMany([$sepatu1, $sepatu2, $sepatu3]);
        $lifestyle->products()->saveMany([$sepatu1, $sepatu2]);

        $jaket = Category::where('title', 'Jaket')->first();
        $vest = Category::where('title', 'Rompi')->first();
        $jaket1 = Product::create([
        	'name' => 'Nike Aeroloft Bomber',
        	'model' => 'Jaket Wanita',
        	'photo' => 'stub-jacket.jpg',
        	'price' => 720000,
            'weight' => rand(1,3) * 1000,
        ]);
        $jaket2 = Product::create([
        	'name' => 'Nike Guild 550',
        	'model' => 'Jaket Pria',
        	'photo' => 'stub-jacket.jpg',
        	'price' => 380000,
            'weight' => rand(1,3) * 1000,
        ]);
        $jaket3 = Product::create([
        	'name' => 'Nike SB Steele',
        	'model' => 'Jaket Pria',
        	'photo' => 'stub-jacket.jpg',
        	'price' => 1200000,
            'weight' => rand(1,3) * 1000,
        ]);
        $jaket->products()->saveMany([$jaket1, $jaket2]);
        $vest->products()->saveMany([$jaket2, $jaket3]);

        $from = database_path() . DIRECTORY_SEPARATOR . 'seeds' . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
        $to = public_path() . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR;
        File::copy($from . 'stub-jacket.jpg', $to . 'stub-jacket.jpg');
        File::copy($from . 'stub-shoes.jpg', $to . 'stub-shoes.jpg');
    }
}
