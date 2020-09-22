<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Item
 *
 * @mixin Eloquent
 */

class Item extends Model
{
    protected $table = 'tbl_item';
    protected $primaryKey = ['itemAuction', 'itemNumber'];
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public function auctionOfItem() {
        return $this->belongsTo(Auction::class, 'itemAuction', 'auctionNumber');
    }

    public function bidsOfItem () {
        return $this->hasMany(Bid::class, ['bidAuction', 'bidItem'], ['itemAuction', 'itemNumber']);
    }

    public function minimumBidTime ($startTime) {
        $bidTime = Bid::query()
            ->where('bidAuction', $this->itemAuction)
            ->where('bidItem', $this->itemNumber)
            ->where('bidAmount', $this->itemStartPrice)
            ->value('bidTime');

        if(empty($bidTime)) {
            return $startTime;
        } else {
            return Carbon::create($bidTime)->addMinutes(1);
        }
    }

    public function minimumBidAmount ($startPrice, $highestBidBefore) {
        if (empty($highestBidBefore)) {
            return $startPrice;
        } else {
            return $highestBidBefore + 0.01;
        }
    }

    public function maximumBidAmount ($minimumBid, $minimumBidAfter) {
        if (empty($minimumBidAfter)) {
            return $minimumBid + 100;
        } else {
            return $minimumBidAfter - 0.01;
        }
    }

    public function getHighestBid() {
        if (empty($this->itemHighestBid)) {
            return 0;
        } else {
            return $this->itemHighestBid;
        }
    }

    public function getHighestBidUntil($time) {
        // $bids = $this->bidsOfItem->where('bidTime', '<', $time);
        $bids = Bid::query()
            ->where('bidAuction', $this->itemAuction)
            ->where('bidItem', $this->itemNumber)
            ->where('bidTime', '<', $time);

        if(empty($bids)) {
            return 0;
        } else {
            return $bids->max('bidAmount');
        }
    }

    public function getLowestBidAfter($time) {
        $bids = Bid::query()
            ->where('bidAuction', $this->itemAuction)
            ->where('bidItem', $this->itemNumber)
            ->where('bidTime', '>', $time);

        if(empty($bids)) {
            return 0;
        } else {
            return $bids->min('bidAmount');
        }
    }


    /*

    public static function auctionHasEnded($auctionStatus)
    {
        if (!is_string($auctionStatus)) {
            throw new Exception("Expected string but got " . gettype($auctionStatus));
        }

        return $auctionStatus != 'open';
    }


     */

}
