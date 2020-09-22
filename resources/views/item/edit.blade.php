@extends('layout')

@section('content')
    <div class="row justify-content-center h-50">
        <div class="col-md-8 align-self-center">
            <div class="card">
                <div class="card-header">Edit Item</div>
                <div class="card-body">
                    <form action="{{route('item.update', ['auction' => $item->itemAuction, 'item' => $item->itemNumber])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="itemTitle" class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input type="text" id="itemTitle" class="form-control" name="itemTitle" value="{{$item->itemTitle}}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="itemDescription" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <input type="text" id="itemDescription" class="form-control" name="itemDescription" value="{{$item->itemDescription}}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="itemCategory" class="col-md-4 col-form-label text-md-right">Category</label>
                            <div class="col-md-6">
                                <select name="itemCategory" id="itemCategory" class="form-control" autofocus>
                                    @foreach($categories as $category)
                                    @if($category->categoryNumber == $item->itemCategory)
                                        <option value="{{$category->categoryNumber}}" selected>{{$category->categoryNumber}}&Tab;{{$category->categoryName}}</option>
                                    @else
                                        <option value="{{$category->categoryNumber}}">{{$category->categoryNumber}}&Tab;{{$category->categoryName}}</option>
                                    @endif
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="itemImage" class="col-md-4 col-form-label text-md-right">Image</label>
                            <div class="col-md-5">
                                <div class="custom-file">
                                    <input type="file" id="itemImage" class="custom-file-input" name="itemImage" value="{{$item->itemImage}}" autofocus>
                                    <label class="custom-file-label" for="itemImage">{{$item->itemImage}}</label>
                                </div>
                            </div>
                            <div class="col-md-1 justify-content-right">
                                <img src="{{getenv('APP_URL').'/'.getenv('AUCTION_IMAGE_DIRECTORY_PATH').'/'.$item->itemImage}}"
                                     width="{{getenv('AUCTION_IMAGE_WIDTH')/4}}"
                                     height="{{getenv('AUCTION_IMAGE_HEIGHT')/4}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="itemStartPrice" class="col-md-4 col-form-label text-md-right">StartPrice</label>
                            <div class="col-md-6">
                                <input type="text" id="itemStartPrice" class="form-control" name="itemStartPrice" value="{{$item->itemStartPrice}}" readonly>
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








