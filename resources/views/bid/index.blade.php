@extends('layout')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2>
                                <a href="{{route('item.index', ['auction' => $item->itemAuction])}}">
                                    Bids op Item {{$item->itemNumber}} van Auction {{$item->itemAuction}}
                                </a>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('bid.index', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="get" class="form-inline justify-content-center" id="filter">
                                @csrf
                                @method('GET')
                                <input type="text" name="bidAmountFrom" id="bidAmountFrom" placeholder="Amount from" class="form-control">
                                <input type="text" name="bidAmountTo" id="bidAmountTo" placeholder="Amount to" class="form-control">
                                <input type="text" name="bidUser" id="bidUser" placeholder="User" class="form-control">
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
                            <form action="{{route('bid.index', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="get" class="form-inline justify-content-start" id="sort">
                                @csrf
                                @method('GET')
                                <select name="column" id="column" class="form-control">
                                    <option value="bidAmount" selected>Amount / Time</option>
                                    <option value="bidUser">User</option>
                                </select>
                                <select name="direction" id="direction" class="form-control">
                                    <option value="asc">Asc</option>
                                    <option value="desc" selected>Desc</option>
                                </select>
                                <button class="btn btn-warning" type="submit" name="sort" value="sort">
                                    <i class="material-icons">&#xE242;</i>
                                    <span>Sort</span>
                                </button>
                            </form>
                        </div>
                        <div class="col-sm-2">
                            <a href="{{route('bid.create', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add</span>
                            </a>
                            <form action="{{route('bid.destroy', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="post" id="deleteForm">
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

                <div class="d-flex h-50">
                    <table class="table table-striped table-hover col-sm-6">
                        <tr>
                            <th>Title:</th>
                            <td>{{$item->itemTitle}}</td>
                        </tr>
                        <tr>
                            <th>Image:</th>
                            <td><img src="{{getenv('APP_URL').'/'.getenv('AUCTION_IMAGE_DIRECTORY_PATH').'/'.$item->itemImage}}"
                                     width="{{getenv('AUCTION_IMAGE_WIDTH')}}"
                                     height="{{getenv('AUCTION_IMAGE_HEIGHT')}}"></td>
                        </tr>
                        <tr>
                            <th>Category:</th>
                            <td>{{$item->categoryName}}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{$item->itemDescription}}</td>
                        </tr>
                        <tr>
                            <th>Highestbidder:</th>
                            <td>{{$item->userName}}</td>
                        </tr>
                        <tr>
                            <th>Highestbid:</th>
                            <td>{{$item->itemHighestBid}}</td>
                        </tr>

                    </table>
                <table class="table table-striped table-hover col-sm-6">
                    <thead>
                    <tr>
                        <th>
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
                        </th>
                        <th>Amount</th>
                        <th>Bidder</th>
                        <th>Time (D/M/Y)</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($bids as $bid)
                        <tr>
                            <td>
							<span class="custom-checkbox">
								<input type="checkbox" name="checkbox" id="{{$bid->bidAmount}}">
                                <label for="{{$bid->bidAmount}}"></label>
							</span>
                            </td>
                            <td>{{$bid->bidAmount}}</td>
                            <td>{{$bid->userName}}</td>
                            {{-- <td>{{$bid->bidTime->format("d-m-Y H:i:s")}}</td> --}}
                            <td>{{Carbon\Carbon::parse($bid->bidTime)->format("d-m-Y H:i:s")}}</td>

                            <td class="d-flex">
                                <form action="{{route('bid.edit', ['auction' => $bid->bidAuction, 'item' => $bid->bidItem, 'amount' => $bid->bidAmount])}}" method="get">
                                    @csrf
                                    @method('GET')
                                    <button class="btn bmd-btn-icon" type="submit" >
                                        <i class="material-icons edit" title="Edit">&#xE254;</i>
                                    </button>
                                </form>
                                <form action="{{route('bid.destroy', ['auction' => $bid->bidAuction, 'item' => $bid->bidItem, 'amount' => $bid->bidAmount])}}" method="post">
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
                </div>

                <div class="clearfix">
                    <div class="hint-text pull-right">Showing <b>{{$bids->count()}}</b> out of <b>{{$bids->total()}}</b> entries</div>
                    {{$bids->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection





