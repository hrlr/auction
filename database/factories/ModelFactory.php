<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Auction;
use App\Bid;
use App\Category;
use App\Item;
use App\User;
use Faker\Generator as Faker;

function autoIncrement(int $startValue) {
    for ($i = $startValue; $i < 10000; $i++) {
        yield $i;
    }
}

$autoIncrement = autoIncrement(1);

$factory->define(User::class, function(Faker $faker) use($autoIncrement) {
    $autoIncrement->next();
    $emailParts = explode('@', $faker->safeEmail);
    $userEmail = substr($emailParts[0], 0, 30 - strlen($emailParts[1]) - 1);
    $userEmail = $userEmail.'@'.$emailParts[1];

    return [
        'userNumber' => $autoIncrement->current(),
        'userEmail' => $userEmail,
        'userName' => substr($faker->userName(), 0, 20),
        'userAddress1' => substr($faker->streetName.' '.$faker->numberBetween(1, 100), 0, 30),
        'userAddress2' => substr($faker->city, 0, 30),
        'userPostCode' => substr($faker->postcode, 0, 9),
        'userCountry' => 'Nederland',
        'userBirthDate' => $faker->dateTimeBetween('-60 years', '-15 years'),
        'userStatus' => $faker->randomElement([0, 1]),
    ];
});

$autoIncrement = autoIncrement(0);

$factory->define(Auction::class, function(Faker $faker) use ($autoIncrement) {
    $autoIncrement->next();
    $randomSeller = User::all()->where('userStatus', 1)->random();
    return [
        'auctionNumber' => $autoIncrement->current(),
        'auctionTitle'	=> $faker->text(50),
        'auctionDuration' => ($faker->boolean(50) ? 7 : $faker->numberBetween($min = 1, $max = 30)),
        'auctionStartTime' => $faker->dateTimeBetween('-2 weeks', 'now'),
        'auctionSeller' => $randomSeller->userNumber,
    ];
});

$factory->define(Item::class, function(Faker $faker) {
    $itemImage = $faker->image(
        getenv('AUCTION_IMAGE_DIRECTORY_PATH'),
        getenv('AUCTION_IMAGE_WIDTH'),
        getenv('AUCTION_IMAGE_HEIGHT'),
        null,
        $fullPath = false
    );

    return [
        // 'itemAuction' => $randomAuction->auctionNumber,
        // 'itemNumber' => $itemNumber,
        'itemTitle' => $faker->text(50),
        'itemDescription' => $faker->text(200),
        // 'itemcategory'	=> $faker->randomElement($categoryNumbers),
         'itemImage' => $itemImage,
        // 'itemImage' => "image.jpg",
        'itemStartPrice' => $faker->randomFloat(0, 1, 1000),
    ];
});

$factory->define(Bid::class, function(Faker $faker) {


    return [
       // 'bidAuction' => $randomItem->itemAuction,
       // 'bidItem' => $randomItem->itemNumber,
       // 'bidAmount' => $bidAmount,
       // 'bidUser' => $randomUser->userNumber,
       // 'bidTime' => $bidTime,
   ];
});


