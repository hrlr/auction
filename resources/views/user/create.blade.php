@extends('layout')

@section('content')
            <div class="row justify-content-center h-50">
                <div class="col-md-8 align-self-center">
                    <div class="card">
                        <div class="card-header">Add Auction</div>
                        <div class="card-body">
                            <form action="{{route('auction.store')}}" method="post">
                                @csrf

                                <div class="form-group row">
                                    <label for="userEmail" class="col-md-4 col-form-label text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userEmail" class="form-control" name="userEmail" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userName" class="col-md-4 col-form-label text-md-right">Name</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userName" class="form-control" name="userName" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userAddress1" class="col-md-4 col-form-label text-md-right">Address1</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userAddress1" class="form-control" name="userAddress1" placeholder="manadatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userAddress2" class="col-md-4 col-form-label text-md-right">Address2</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userAddress2" class="form-control" name="userAddress2" placeholder="optional" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userPostCode" class="col-md-4 col-form-label text-md-right">PostCode</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userPostCode" class="form-control" name="userPostCode" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userCountry" class="col-md-4 col-form-label text-md-right">Country</label>
                                    <div class="col-md-6">
                                        <input type="text" id="userCountry" class="form-control" name="userCountry" placeholder="default Nederland" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userBirthDate" class="col-md-4 col-form-label text-md-right">BirthDate</label>
                                    <div class="col-md-6">
                                        <input type="datetime-local" id="userBirthDate" class="form-control" name="userBirthDate" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="userStatus" class="col-md-4 col-form-label text-md-right">Status</label>
                                    <div class="col-md-6">
                                        <input type="datetime-local" id="userStatus" class="form-control" name="userStatus" placeholder="mandatory" autofocus>
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




