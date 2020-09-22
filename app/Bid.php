<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Bid
 *
 * @mixin Eloquent
 */

class Bid extends Model
{
    protected $table = 'tbl_bid';
    protected $primaryKey = ['bidAuction', 'bidItem', 'bidAmount'];
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];
    // protected $dates = ['bidTime'];
}
