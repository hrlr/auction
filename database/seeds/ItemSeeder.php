<?php

use App\Auction;
use App\Category;
use App\Item;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = Category::query()->doesntHave('children')->pluck('categoryNumber');
        $categoryNumbers = $categories->toArray();

        foreach(range(1, 500) as $count) {
            $randomAuction = Auction::all()->random();
            $numberOfItems = $randomAuction->itemsOfAuction->count();
            $itemNumber = $numberOfItems + 1;
            $randomKey = array_rand($categoryNumbers);
            $itemCategory = $categories[$randomKey];

            factory(Item::class)->create([
                'itemAuction' => $randomAuction->auctionNumber,
                'itemNumber' => $itemNumber,
                'itemCategory' => $itemCategory,
                ]);
        }

    }
}
