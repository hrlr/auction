@extends('layout')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2><a href="{{route('auction.index')}}">Items van Auction {{$itemAuction}}</a></h2>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('item.index', $itemAuction)}}" method="get" class="form-inline justify-content-center" id="filter">
                                @csrf
                                @method('GET')
                                <input type="text" name="itemNumberFrom" id="itemNumberFrom" placeholder="ID from" class="form-control">
                                <input type="text" name="itemNumberTo" id="itemNumberTo" placeholder="ID to" class="form-control">
                                <input type="text" name="itemTitle" id="name" placeholder="Name" class="form-control">
                                <button class="btn btn-warning" type="submit" name="filter" value="filter">
                                    <i class="material-icons">&#xE94E;</i>
                                    <span>Filter</span>
                                </button>
                                <button class="btn btn-warning" type="submit" name="filter" value="clear">
                                    <i class="material-icons">&#xE8EE;</i>
                                    <span>Clear</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-3">
                            <form action="{{route('item.index', $itemAuction)}}" method="get" class="form-inline justify-content-start" id="sort">
                                @csrf
                                @method('GET')
                                <select name="column" id="column" class="form-control">
                                    <option value="itemNumber" selected>ID</option>
                                    <option value="itemTitle">Title</option>
                                </select>
                                <select name="direction" id="direction" class="form-control">
                                    <option value="asc" selected>Asc</option>
                                    <option value="desc">Desc</option>
                                </select>
                                <button class="btn btn-warning" type="submit" name="sort" value="sort">
                                    <i class="material-icons">&#xE242;</i>
                                    <span>Sort</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <a href="{{route('item.create', $itemAuction)}}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add</span>
                            </a>
                            <form action="{{route('item.destroy', ['auction' => $itemAuction])}}" method="post" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="hiddenInput" id="hiddenInput">
                                <button class="btn btn-danger" id="deleteButton">
                                    <i class="material-icons delete" title="Delete">&#xE15C;</i>
                                    <span>Delete</span>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                        </th>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Image</th>
                        <th>StartPrice</th>
                        <th>Highest Bidder</th>
                        <th>Highest Bid</th>
                        <th>#Bids</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>
							<span class="custom-checkbox">
								<input type="checkbox" name="checkbox" id="{{$item->itemNumber}}">
                                <label for="{{$item->itemNumber}}"></label>
							</span>
                            </td>
                            <td>{{$item->itemNumber}}</td>
                            <td>{{$item->itemTitle}}</td>
                            <td>{{$item->categoryName}}</td>
                            <td><img src="{{getenv('APP_URL').'/'.getenv('AUCTION_IMAGE_DIRECTORY_PATH').'/'.$item->itemImage}}"
                                width="{{getenv('AUCTION_IMAGE_WIDTH')/4}}"
                                height="{{getenv('AUCTION_IMAGE_HEIGHT')/4}}">
                            </td>
                            <td>{{$item->itemStartPrice}}</td>
                            <td>{{$item->userName}}</td>
                            <td>{{$item->itemHighestBid}}</td>
                            <td>
                                <form action="{{route('bid.index', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="get">
                                    @csrf
                                    @method('GET')
                                    {{$item->itemNumberOfBids}}
                                    <button class="btn bmd-btn-icon" type="submit">
                                        <i class="material-icons" title="Bids">&#xE313;</i>
                                    </button>
                                </form>
                            </td>

                            <td class="d-flex">
                                <form action="{{route('item.edit', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="get">
                                    @csrf
                                    @method('GET')
                                    <button class="btn bmd-btn-icon" type="submit" >
                                        <i class="material-icons edit" title="Edit">&#xE254;</i>
                                    </button>
                                </form>
                                <form action="{{route('item.destroy', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn bmd-btn-icon" type="submit">
                                        <i class="material-icons delete" title="Delete">&#xE872;</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{$items->count()}}</b> out of <b>{{$items->total()}}</b> entries</div>
                    {{$items->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection





