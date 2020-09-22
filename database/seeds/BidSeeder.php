<?php

use App\Auction;
use App\Bid;
use App\User;
use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1, 2000) as $count) {
            $randomAuction = Auction::all()->random();
            $itemsOfAuction = $randomAuction->itemsOfAuction;
            if($itemsOfAuction->count() == 0) {
                continue;
            }
            $randomItem = $itemsOfAuction->random();
            $randomUser = User::all()->where('userNumber', '<>', $randomAuction->auctionSeller)->random();

            $maximumBidTime = ($randomAuction->auctionClosed ? $randomAuction->auctionEndTime : now());
            $minimumBidTime = $randomItem->minimumBidTime($randomAuction->auctionStartTime);
            $bidTime = $faker->dateTimeBetween($minimumBidTime, $maximumBidTime);

            $highestBidUntil = $randomItem->getHighestBidUntil($bidTime);
            $minimumBidAmount = $randomItem->minimumBidAmount($randomItem->itemStartPrice, $highestBidUntil);
            $lowestBidAfter = $randomItem->getLowestBidAfter($bidTime);
            $maximumBidAmount = $randomItem->maximumBidAmount($minimumBidAmount, $lowestBidAfter);
            if($maximumBidAmount - $minimumBidAmount <= 0.01) {
                continue;
            }
            $bidAmount = $faker->randomFloat(2, $minimumBidAmount, $maximumBidAmount);

            factory(Bid::class, 1)->create([
                'bidAuction' => $randomItem->itemAuction,
                'bidItem' => $randomItem->itemNumber,
                'bidAmount' => $bidAmount,
                'bidUser' => $randomUser->userNumber,
                'bidTime' => $bidTime,
                ]);
        }
    }
}
