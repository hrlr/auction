@extends('layout')

@section('content')
            <div class="row justify-content-center h-50">
                <div class="col-md-8 align-self-center">
                    <div class="card">
                        <div class="card-header">Add Item</div>
                        <div class="card-body">
                            <form action="{{route('item.store', $itemAuction)}}" method="post"  enctype="multipart/form-data">
                                @csrf

                                <div class="form-group row">
                                    <label for="itemTitle" class="col-md-4 col-form-label text-md-right">Title</label>
                                    <div class="col-md-6">
                                        <input type="text" id="itemTitle" class="form-control" name="itemTitle" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="itemDescription" class="col-md-4 col-form-label text-md-right">Description</label>
                                    <div class="col-md-6">
                                        <input type="text" id="itemDescription" class="form-control" name="itemDescription" placeholder="mandatory" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="itemCategory" class="col-md-4 col-form-label text-md-right">Category</label>
                                    <div class="col-md-6">
                                        <select name="itemCategory" id="itemCategory" class="form-control" autofocus>
                                            @foreach($categories as $category) {
                                            <option value="{{$category->categoryNumber}}">{{$category->categoryNumber}}&Tab;{{$category->categoryName}}</option>
                                            }
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="itemImage" class="col-md-4 col-form-label text-md-right">Image</label>
                                    <div class="col-md-6">
                                        <div class="custom-file">
                                            <input type="file" id="itemImage" class="custom-file-input" name="itemImage" placeholder="mandatory" autofocus>
                                            <label class="custom-file-label" for="itemImage">Choose file</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="itemStartPrice" class="col-md-4 col-form-label text-md-right">StartPrice</label>
                                    <div class="col-md-6">
                                        <input type="text" id="itemStartPrice" class="form-control" name="itemStartPrice" placeholder="mandatory" autofocus>
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




