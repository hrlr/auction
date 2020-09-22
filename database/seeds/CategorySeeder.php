<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Relics',
            'Fashion',
            'Jewelery',
            'Books',
            'Furniture',
            'Appliances',
            'Electronics',
            'Computers',
        ];

        Category::create([
            'categoryNumber' => 0,
            'categoryName' => 'ROOT',
            'categoryParent' => 0,
            'categoryVisible' => 0,
            ]
        );

        $categoryNumber = 1;

        foreach ($categories as $categoryName) {

            Category::create([
                'categoryNumber' => $categoryNumber,
                'categoryName' => $categoryName,
                'categoryParent' => rand(0, $categoryNumber - 1),
                'categoryVisible' => 0,
            ]);
            $categoryNumber++;
        }
    }

}
