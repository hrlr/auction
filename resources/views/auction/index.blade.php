@extends('layout')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2><a href="{{route('auction.index')}}">Auctions</a></h2>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('auction.index')}}" method="get" class="form-inline justify-content-center" id="filter">
                                @csrf
                                @method('GET')
                                <input type="text" name="auctionNumberFrom" id="auctionNumberFrom" placeholder="ID from" class="form-control">
                                <input type="text" name="auctionNumberTo" id="auctionNumberTo" placeholder="ID to" class="form-control">
                                <input type="text" name="auctionTitle" id="auctionTitle" placeholder="Name" class="form-control">
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
                            <form action="{{route('auction.index')}}" method="get" class="form-inline justify-content-start" id="sort">
                                @csrf
                                @method('GET')
                                <select name="column" id="column" class="form-control">
                                    <option value="auctionNumber" selected>ID</option>
                                    <option value="auctionTitle">Title</option>
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
                            <a href="{{route('auction.create')}}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add</span>
                            </a>
                            <form action="{{route('auction.destroy')}}" method="post" id="deleteForm">
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
                        <th>Duration</th>
                        <th>StartTime (D/M/Y)</th>
                        <th>EndTime (D/M/Y)</th>
                        <th>Closed</th>
                        <th>Seller</th>
                        <th>#Items</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($auctions as $auction)
                        <tr>
                            <td>
							<span class="custom-checkbox">
								<input type="checkbox" name="checkbox" id="{{$auction->auctionNumber}}">
                                <label for="{{$auction->auctionNumber}}"></label>
							</span>
                            </td>
                            <td>{{$auction->auctionNumber}}</td>
                            <td>{{$auction->auctionTitle}}</td>
                            <td>{{$auction->auctionDuration}} days</td>
                            {{-- <td>{{$auction->auctionStartTime->format("d-m-Y H:i:s")}}</td> --}}
                            <td>{{Carbon\Carbon::parse($auction->auctionStartTime)->format("d-m-Y H:i:s")}}</td>
                            {{-- <td>{{$auction->auctionEndTime->format("d-m-Y H:i:s")}}</td> --}}
                            <td>{{Carbon\Carbon::parse($auction->auctionEndTime)->format("d-m-Y H:i:s")}}</td>
                            @if($auction->auctionClosed)
                                <td>Closed</td>
                            @else
                                <td>Open</td>
                            @endif
                            <td>{{$auction->userName}}</td>
                            <td>
                                <form action="{{route('item.index', $auction->auctionNumber)}}" method="get">
                                    @csrf
                                    @method('GET')
                                    {{$auction->auctionNumberOfItems}}
                                    <button class="btn bmd-btn-icon" type="submit">
                                        <i class="material-icons" title="Items">&#xE313;</i>
                                    </button>
                                </form>
                            </td>

                            <td class="d-flex">

                                <form action="{{route('auction.edit', $auction->auctionNumber)}}" method="get">
                                    @csrf
                                    @method('GET')
                                    <button class="btn bmd-btn-icon" type="submit" >
                                        <i class="material-icons edit" title="Edit">&#xE254;</i>
                                    </button>
                                </form>
                                <form action="{{route('auction.destroy', $auction->auctionNumber)}}" method="post">
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
                    <div class="hint-text">Showing <b>{{$auctions->count()}}</b> out of <b>{{$auctions->total()}}</b> entries</div>
                    {{$auctions->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection





