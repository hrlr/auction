<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(CategorySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AuctionSeeder::class);
        $this->call(ItemSeeder::class);
        $this->call(BidSeeder::class);

        Model::reguard();
    }
}
