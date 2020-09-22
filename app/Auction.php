<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Auction
 *
 * @mixin Eloquent
 */

class Auction extends Model
{
    protected $table = 'tbl_auction';
    protected $primaryKey = 'auctionNumber';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    // protected $dates=['auctionStartTime', 'auctionEndTime'];

    public function itemsOfAuction() {
        return $this->hasMany(Item::class, 'itemAuction','auctionNumber');
    }

}

