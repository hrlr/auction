@extends('layout')

@section('content')
    <div class="row justify-content-center h-50">
        <div class="col-md-8 align-self-center">
            <div class="card">
                <div class="card-header">Edit Auction</div>
                <div class="card-body">
                    <form action="{{route('auction.update', $auction->auctionNumber)}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="auctionTitle" class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input type="text" id="auctionTitle" class="form-control" name="auctionTitle" value="{{$auction->auctionTitle}}" required autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="auctionDuration" class="col-md-4 col-form-label text-md-right">Duration</label>
                            <div class="col-md-6">
                                <input type="text" id="auctionDuration" class="form-control" name="auctionDuration" value="{{$auction->auctionDuration}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="auctionStartTime" class="col-md-4 col-form-label text-md-right">Start Time</label>
                            <div class="col-md-6">
                                <input type="datetime-local" id="auctionStartTime" class="form-control" name="auctionStartTime" value="{{$auction->auctionStartTime}}" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="auctionSeller" class="col-md-4 col-form-label text-md-right">Seller</label>
                            <div class="col-md-6">
                                <select name="auctionSeller" id="auctionSeller" class="form-control" autofocus>
                                    @foreach($sellers as $seller) {
                                    @if($seller->userNumber == $auction->auctionSeller)
                                        <option value="{{$seller->userNumber}}" selected>{{$seller->userNumber}}&Tab;{{$seller->userName}}</option>
                                    @else
                                        <option value="{{$seller->userNumber}}">{{$seller->userNumber}}&Tab;{{$seller->userName}}</option>
                                    }
                                    @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="col-md-8 offset-md-4">
                            <input type="submit" class="btn btn-default" name="action" value="Cancel">
                            <input type="submit" class="btn btn-info" name="action" value="Save">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection








