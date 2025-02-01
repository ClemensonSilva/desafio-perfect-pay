<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use \App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => fake()->unique()->randomElement([
                'iPhone 14', 
                'Samsung Galaxy S23', 
                'Google Pixel 7',
                'Nike Dri-FIT', 
                'Adidas Originals Tee', 
                'H&M Basic Tee',
                'Nike Air Zoom Pegasus 40', 
                'Adidas Ultraboost 22', 
                'Asics Gel-Kayano 29',
                'Rolex Submariner', 
                'Casio G-Shock', 
                'Apple Watch Series 8',
                'Pride and Prejudice by Jane Austen', 
                'The Notebook by Nicholas Sparks', 
                'Me Before You by Jojo Moyes',
                'IKEA KIVIK', 
                'West Elm Harmony', 
                'La-Z-Boy Reclining Sofa',
                'LG InstaView Door-in-Door', 
                'Samsung Family Hub', 
                'Whirlpool Side-by-Side',
                'Pantene Pro-V', 
                'L\'Oréal Paris Elvive', 
                'Head & Shoulders Classic Clean',
                'Traxxas Rustler 4X4', 
                'ARRMA Granite Voltage', 
                'Redcat Racing Everest Gen7',
                'Barilla Spaghetti', 
                'De Cecco Penne Rigate', 
                'Rummo Fusilli',
                'Château Margaux', 
                'Penfolds Grange', 
                'Antinori Tignanello',
                'DeWalt DCD791D2', 
                'Bosch GSR12V-140FCB22', 
                'Makita XFD131',
                'Adidas Al Rihla Pro', 
                'Nike Flight', 
                'Puma La Liga 1',
                'Moleskine Classic', 
                'Leuchtturm1917 Hardcover', 
                'Rhodia Webnotebook',
                'Dawn Ultra', 
                'Fairy Platinum', 
                'Palmolive Essential Clean'
            ], false
            ),
            'description' => fake()->sentence(),
            'price' => fake()->numberBetween(100,1000)
        ];
    }
}
