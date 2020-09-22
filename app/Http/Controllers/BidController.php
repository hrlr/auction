<?php

namespace App\Http\Controllers;

use App\Application\Filters\BidFilter;
use App\Application\Sorters\BidSorter;
use App\Auction;
use App\Bid;
use App\Item;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BidController extends Controller {
    protected $filter;
    protected $sort;

    public function __construct(BidFilter $filter, BidSorter $sort) {
        $this->filter = $filter;
        $this->sort = $sort;
    }

    public function index(Request $request, $itemAuction, $itemNumber) {
        $item = DB::table('tbl_item')
            ->join('tbl_category', 'itemCategory', '=', 'categoryNumber' )
            ->leftJoin('tbl_user', 'itemHighestBidder', '=', 'userNumber')
            ->where('itemAuction', $itemAuction)
            ->where( 'itemNumber', $itemNumber)
            ->first();

        $query = DB::table('tbl_bid')
            ->join('tbl_user', 'bidUser', '=', 'userNumber')
            ->where('bidAuction', $itemAuction)
            ->where('bidItem', $itemNumber);
        //    ->orderBy('bidAmount', 'desc');
        $query = $this->filter->applyFilter($query);
        $query = $this->sort->applySort($query);

        $bids = $query->paginate(7);

        return view('bid.index', compact('item', 'bids'));
    }

    public function create(Request $request, $itemAuction, $itemNumber) {
        $bidAuction = $itemAuction;
        $bidItem = $itemNumber;

        $auction = Auction::query()
            ->where('auctionNumber', $bidAuction);
        $auctionClosed = $auction->value('auctionClosed');

        if($auctionClosed == 0) {
            $item = Item::query()
                ->where('itemAuction', $itemAuction)
                ->where('itemNumber', $itemNumber);
            $itemHighestBid = $item->value('itemHighestBid');
            $itemStartPrice = $item->value('itemStartPrice');
            $minimumBidAmount = max($itemHighestBid, $itemStartPrice);

            $auctionSeller = $auction->value('auctionSeller');
            $users = User::query()
                ->where('userNumber', "<>", 9)
                ->where('userNumber', '<>', $auctionSeller)
                ->get();

            return view('bid.create', compact('bidAuction', 'bidItem', 'minimumBidAmount', 'users'));
        }
        else {
            return redirect(route('bid.index', ['auction' => $bidAuction, 'item' => $bidItem]))
                ->withErrors(['item_auction_closed' => 'Auction closed']);
        }
    }

    public function store(Request $request, $bidAuction, $bidItem) {
        if($request->input('action') == 'Add') {
            $storeData = $this->validateBid($request);
            $bid = new Bid($storeData);
            $bid->bidAuction = $bidAuction;
            $bid->bidItem = $bidItem;
            $bid->bidTime = now();

            $bid->save();
        }

        return redirect(route('bid.index', ['auction' => $bidAuction, 'item' => $bidItem]));
    }

    public function show($bidAuction, $bidItem, $bidAmount) {
        return view('bid.show', compact('bidAuction', 'bidItem', 'bidAmount'));
    }

    public function edit(Request $request, $bidAuction, $bidItem, $bidAmount) {
        $bid = Bid::query()
            ->where('bidAuction', $bidAuction)
            ->where('bidItem', $bidItem)
            ->where('bidAmount', $bidAmount)
            ->first();

        $bidTime = Carbon::createFromFormat('Y-m-d H:i:s.u', $bid->bidTime);
        $bid->bidTime = $bidTime->toDateTimeLocalString();

        $auctionSeller = Auction::query()
            ->where('auctionNumber', $bidAuction)
            ->pluck('auctionSeller');

        $users = User::query()
            ->where('userNumber', "<>", 9)
            ->where('userNumber', '<>', $auctionSeller)
            ->get();

        return view('bid.edit', compact('bid', 'users'));
    }

    public function update(Request $request, $bidAuction, $bidItem, $bidAmount) {
        if($request->input('action') == 'Save') {
            $updateData = $this->validateBid($request);
            $bid = Bid::query()
                ->where('bidAuction', $bidAuction)
                ->where('bidItem', $bidItem)
                ->where('bidAmount', $bidAmount);

            $bid->update($updateData);
        }

        return redirect(route('bid.index', ['auction' => $bidAuction, 'item' => $bidItem, 'amount' => $bidAmount]));
    }

    public function destroy(Request $request, $bidAuction, $bidItem, $bidAmount = null) {
        if($bidAmount) {
            Bid::query()
                ->where('bidAuction', $bidAuction)
                ->where('bidItem', $bidItem)
                ->where('bidAmount', $bidAmount)
                ->delete();
        } else {
            $ids = json_decode($request->input('hiddenInput'));
            Bid::query()
                ->where('bidAuction', $bidAuction)
                ->where('bidItem', $bidItem)
                ->whereIn("bidAmount", $ids)
                ->delete();
        }

        return redirect(route('bid.index', ['auction' => $bidAuction, 'item' => $bidItem]));
    }

    private function validateBid(Request $request) {
        return $request->validate([
            'bidAmount' => 'required|numeric|min:'.$request->input('minimumBidAmount'),
            'bidUser' => 'required|integer',
        ]);
    }
}
