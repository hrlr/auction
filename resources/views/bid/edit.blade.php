@extends('layout')

@section('content')
            <div class="row justify-content-center h-50">
                <div class="col-md-8 align-self-center">
                    <div class="card">
                        <div class="card-header">Edit Bid</div>
                        <div class="card-body">
                            <form action="{{route('bid.update', ['auction' => $bid->bidAuction, 'item' => $bid->bidItem, 'amount' => $bid->bidAmount])}}" method="post"  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="form-group row">
                                    <label for="bidAmount" class="col-md-4 col-form-label text-md-right">Amount</label>
                                    <div class="col-md-6">
                                        <input type="text" id="bidAmount" class="form-control" name="bidAmount" value="{{$bid->bidAmount}}" readonly>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bidUser" class="col-md-4 col-form-label text-md-right">User</label>
                                    <div class="col-md-6">
                                        <select name="bidUser" id="bidUser" class="form-control" autofocus>
                                            @foreach($users as $user)
                                            @if($user->userNumber == $bid->bidUser)
                                                <option value="{{$user->userNumber}}" selected>{{$user->userNumber}}&Tab;{{$user->userName}}</option>
                                            @else
                                                <option value="{{$user->userNumber}}">{{$user->userNumber}}&Tab;{{$user->userName}}</option>
                                            @endif
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="bidTime" class="col-md-4 col-form-label text-md-right">Time</label>
                                    <div class="col-md-6">
                                        <input type="datetime-local" id="bidTime" class="form-control" name="bidTime" value="{{$bid->bidTime}}" readonly>
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




