<?php

namespace App\Http\Controllers;

use App\Application\Filters\ItemFilter;
use App\Application\Sorters\ItemSorter;
use App\Auction;
use App\Category;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller {
    protected $filter;
    protected $sort;

    public function __construct(ItemFilter $filter, ItemSorter $sort) {
        $this->filter = $filter;
        $this->sort = $sort;
    }

    public function index(Request $request, $itemAuction) {
        $query = DB::table('tbl_item')
            ->leftJoin('tbl_user', 'itemHighestBidder', '=', 'userNumber')
            ->join('tbl_category', 'itemCategory', '=', 'categoryNumber')
            ->where('itemAuction', $itemAuction);
        $query = $this->filter->applyFilter($query);
        $query = $this->sort->applySort($query);

        $items = $query->paginate(6);

        return view('item.index', compact('itemAuction', 'items'));
    }

    public function create($itemAuction) {
        $auctionClosed = Auction::query()
            ->where('auctionNumber', $itemAuction)
            ->value('auctionClosed');

        if($auctionClosed == 0) {
            $categories = Category::query()
                ->doesntHave('children')
                ->get();

            return view('item.create', compact('itemAuction', 'categories'));

        } else {
            return redirect(route('item.index', ['auction' => $itemAuction]))
             ->withErrors(['item_auction_closed' => 'Auction closed']);
        }

    }

    public function store(Request $request, $itemAuction) {
        if($request->input('action') == 'Add') {

            $storeData = $this->validateItem($request);
            $item = new Item($storeData);
            $item->itemAuction = $itemAuction;

            $maxItemNumber = DB::table('tbl_item')
                ->where('itemAuction', $itemAuction)
                ->max('itemNumber');
            $item->itemNumber = $maxItemNumber + 1;

            // $imagePath = getenv('AUCTION_IMAGE_DIRECTORY_PATH').'/';
            // $imagePath = asset('/css/images/auctions');
            // $width = getenv('AUCTION_IMAGE_WIDTH');
            // $height = getenv('AUCTION_IMAGE_HEIGHT');

            // $imageFullName = $request->file('itemImage')->getClientOriginalName();
            // $imageFileName = pathinfo($imageFullName,PATHINFO_FILENAME);
            // $imageExtension = $request->file('itemImage')->getClientOriginalExtension();
            // $imageFileNameToStore = $imageFileName.'-'.time().'.'.$imageExtension;
            // $image = $request->file('itemImage')->storeAs('', $imageFileNameToStore);
            // $item->itemImage = $imageFileNameToStore;

            $itemImage = $request->file('itemImage')->getClientOriginalName();
            $request->file('itemImage')->storeAs('', $itemImage);
            $item->itemImage = $itemImage;

            $item->save();
        }

        return redirect(route('item.index', ['auction' => $itemAuction]));
    }


    public function show(Item $item) {
        return view('item.show', $item);
    }

    public function edit(Request $request, $itemAuction, $itemNumber) {
        $item = Item::query()
            ->where('itemAuction', $itemAuction)
            ->where('itemNumber', $itemNumber)
            ->first();

        $categories = Category::query()
            ->doesntHave('children')
            ->get();

        return view('item.edit', compact('item', 'categories'));
    }


    public function update(Request $request, $itemAuction, $itemNumber) {
        if($request->input('action') == 'Save') {
            $updateData = $this->validateItem($request);
            $item = Item::query()
                ->where('itemAuction', $itemAuction)
                ->where('itemNumber', $itemNumber);

            $itemImage = $request->file('itemImage')->getClientOriginalName();
            $request->file('itemImage')->storeAs('', $itemImage);
            $item->itemImage = $itemImage;

            $item->update($updateData);
        }

        return redirect(route('item.index', ['auction' => $itemAuction]));
    }

    public function destroy(Request $request, $itemAuction, $itemNumber = null) {
        // $auctionNumber = $auction->auctionNumber;
        if($itemNumber) {
            Item::query()
                ->where('itemAuction', $itemAuction)
                ->where('itemNumber', $itemNumber)
                ->delete();
        } else {
            $ids = json_decode($request->input('hiddenInput'));
            Item::query()
                ->where('itemAuction', $itemAuction)
                ->whereIn("itemNumber", $ids)
                ->delete();
        }

        return redirect(route('item.index', ['auction' => $itemAuction]));
    }

    private function validateItem(Request $request) {
        return $request->validate([
            'itemTitle' => 'required|string|min:3|max:50',
            'itemDescription' =>	'required|string',
            'itemCategory' => 'required|integer',
            'itemImage' => 'required|image|mimes:jpeg,png,jpg,gif|max:20000',
            'itemStartPrice' => 'required|numeric',
        ]);
    }
}
