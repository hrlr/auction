@extends('layout')

@section('content')
            <div class="row justify-content-center h-50">
                <div class="col-md-8 align-self-center">
                    <div class="card">
                        <div class="card-header">Add Bid</div>
                        <div class="card-body">
                            <form action="{{route('bid.store', ['auction' => $bidAuction, 'item' => $bidItem])}}" method="post"  enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="minimumBidAmount" class="col-md-4 col-form-label text-md-right">Minimum Amount</label>
                                    <div class="col-md-6">
                                        <input type="text" id="minimumBidAmount" class="form-control" name="minimumBidAmount" value="{{$minimumBidAmount}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bidAmount" class="col-md-4 col-form-label text-md-right">Amount</label>
                                    <div class="col-md-6">
                                        <input type="text" id="bidAmount" class="form-control" name="bidAmount" placeholder="Mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bidUser" class="col-md-4 col-form-label text-md-right">User</label>
                                    <div class="col-md-6">
                                        <select name="bidUser" id="bidUser" class="form-control" autofocus>
                                            @foreach($users as $user) {
                                            <option value="{{$user->userNumber}}">{{$user->userNumber}}&Tab;{{$user->userName}}</option>
                                            }
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-md-8 offset-md-4">
                                        <input type="submit" class="btn btn-default" name="action" value="Cancel">
                                        <input type="submit" class="btn btn-info" name="action" value="Add">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
@endsection




