<?php

namespace App\Http\Controllers;

use App\Application\Filters\AuctionFilter;
use App\Application\Sorters\AuctionSorter;
use App\Auction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionController extends Controller {
    protected $filter;
    protected $sort;

    public function __construct(AuctionFilter $filter, AuctionSorter $sort) {
        $this->filter = $filter;
        $this->sort = $sort;
    }

    public function index(Request $request) {
        $query = DB::table('tbl_auction')
        ->join('tbl_user', 'auctionSeller', '=', 'userNumber');
        $query = $this->filter->applyFilter($query);
        $query = $this->sort->applySort($query);

        $auctions = $query->paginate(6);

        return view('auction.index', compact('auctions'));
    }

    public function create() {
        $sellers = User::getSellers();

        return view('auction.create', compact('sellers'));
    }

    public function store(Request $request) {
        if($request->input('action') == 'Add') {
            $requestData = $this->validateAuction($request);
            $auction = new Auction();
            $maxAuctionNumber = DB::table('tbl_auction')->max('auctionNumber');
            $auction->auctionNumber = $maxAuctionNumber + 1;
            $auction->auctionTitle = $requestData['auctionTitle'];
            if($requestData['auctionDuration']) {
                $auction->auctionDuration = $requestData['auctionDuration'];
            }
            if($requestData['auctionStartTime']) {
                // $auction->auctionStartTime = str_replace('T', ' ', $requestData['auctionStartTime']);
                $auctionStartTime = $requestData['auctionStartTime'];
                $auction->auctionStartTime = Carbon::parse($auctionStartTime)->format("Y-m-d H:i:s");
            }
            $auction->auctionSeller = $requestData['auctionSeller'];
            $auction->save();
        }

        return redirect(route('auction.index'))->with('completed', 'Auction has been saved!');
    }


    public function show(Auction $auction) {
        return view('auction.show', $auction);
    }

    public function edit(Auction $auction) {
        $auctionStartTime = Carbon::createFromFormat('Y-m-d H:i:s.u', $auction->auctionStartTime);
        $auction->auctionStartTime = $auctionStartTime->toDateTimeLocalString();

        $sellers = User::getSellers();

        return view('auction.edit', compact('auction', 'sellers'));
    }


    public function update(Request $request, Auction $auction) {
        if($request->input('action') == 'Save') {
            $requestData = $this->validateAuction($request);

            $auction->update($requestData);
        }

        return redirect(route('auction.index'))->with('completed', 'Auction has been updated');
    }

    public function destroy(Request $request, Auction $auction) {
        if($auction->auctionNumber) {
            $auction->delete();
        } else {
            $ids = json_decode($request->input('hiddenInput'));
            Auction::whereIn("auctionNumber", $ids)->delete();
        }

        return redirect('/auction')->with('completed', 'Auction has been deleted');
    }

    private function validateAuction(Request $request) {
        return $request->validate([
            'auctionTitle' => 'required|string|max:50',
            'auctionDuration' => 'nullable|integer|min:1|max:30',
            'auctionStartTime' => 'nullable|date',
            'auctionSeller' => 'required|integer|exists:App\User,userNumber',
        ]);
    }
}
