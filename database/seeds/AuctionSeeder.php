<?php

use App\Auction;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteImages();

        factory(Auction::class, 100)->create();
    }

    private function deleteImages()
    {
        $path = getenv('AUCTION_IMAGE_DIRECTORY_PATH');

        // Delete the files names in the folder
        $files = glob("{$path}/*");
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }
}
