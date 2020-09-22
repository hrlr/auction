@extends('layout')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2><a href="{{route('user.index')}}">Users</a></h2>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('user.index')}}" method="get" class="form-inline justify-content-center" id="filter">
                                @csrf
                                @method('GET')
                                <input type="text" name="userNumberFrom" id="userNumberFrom" placeholder="ID from" class="form-control">
                                <input type="text" name="userNumberTo" id="userNumberTo" placeholder="ID to" class="form-control">
                                <input type="text" name="userName" id="userName" placeholder="Name" class="form-control">
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
                            <form action="{{route('user.index')}}" method="get" class="form-inline justify-content-start" id="sort">
                                @csrf
                                @method('GET')
                                <select name="column" id="column" class="form-control">
                                    <option value="userNumber" selected>ID</option>
                                    <option value="userName">Title</option>
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
                            <a href="{{route('user.create')}}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add</span>
                            </a>
                            <form action="{{route('user.destroy')}}" method="post" id="deleteForm">
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
                        <th>Email</th>
                        <th>Name</th>
                        <th colspan="2">Address</th>
                        <th>Postcode</th>
                        <th>Country</th>
                        <th>Birthdate (D/M/Y)</th>
                        <th>Status</th>
                        <th>#Auctions</th>
                        <th>#Bids</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
							<span class="custom-checkbox">
								<input type="checkbox" name="checkbox" id="{{$user->userNumber}}">
                                <label for="{{$user->userNumber}}"></label>
							</span>
                            </td>
                            <td>{{$user->userNumber}}</td>
                            <td>{{$user->userEmail}}</td>
                            <td>{{$user->userName}}</td>
                            <td>{{$user->userAddress1}}</td>
                            <td>{{$user->userAddress2}}</td>
                            <td>{{$user->userPostCode}}</td>
                            <td>{{$user->userCountry}}</td>
                            {{-- <td>{{$user->userBirthDate->format("d-m-Y")}}</td> --}}
                            <td>{{Carbon\Carbon::parse($user->userBirthDate)->format("d-m-Y")}}</td>
                            @switch($user->userStatus)
                                @case(0) <td>Koper</td> @break
                                @case(1) <td>Verkoper</td> @break
                                @case(2) <td>Beheerder</td> @break
                                @case(9) <td>Geblokkeerd</td> @break
                            @endswitch
                            <td>
                                <form action="{{route('auction.index')}}" method="get">
                                    @csrf
                                    @method('GET')
                                    {{$user->userNumberOfAuctions}}
                                    <input type="hidden" name="user_userNumber" value="{{$user->userNumber}}">
                                    <button class="btn bmd-btn-icon" type="submit" name="filter" value="user">
                                        <i class="material-icons" title="Auctions">&#xE313;</i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                {{-- <form action="{{route('bid.index', ['user' => $user->userNumber])}}" method="get"> --}}
                                <form>
                                @csrf
                                    @method('GET')
                                    {{$user->userNumberOfBids}}
                                    <input type="hidden" name="user_userNumber" value="{{$user->userNumber}}">
                                    <button class="btn bmd-btn-icon" type="submit" name="filter" value="user">
                                        <i class="material-icons" title="Auctions">&#xE313;</i>
                                    </button>
                                </form>
                            </td>

                            <td class="d-flex">

                                <form action="{{route('user.edit', $user->userNumber)}}" method="get">
                                    @csrf
                                    @method('GET')
                                    <button class="btn bmd-btn-icon" type="submit" >
                                        <i class="material-icons edit" title="Edit">&#xE254;</i>
                                    </button>
                                </form>
                                <form action="{{route('user.destroy', $user->userNumber)}}" method="post">
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
                    <div class="hint-text">Showing <b>{{$users->count()}}</b> out of <b>{{$users->total()}}</b> entries</div>
                    {{$users->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection





