@extends('layout')

@section('content')
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-2">
                            <h2><a href="{{route('category.index')}}">Categories</a></h2>
                        </div>
                        <div class="col-sm-5">
                            <form action="{{route('category.index')}}" method="get" class="form-inline justify-content-center" id="filter">
                                @csrf
                                @method('GET')
                                <input type="text" name="categoryNumberFrom" id="categoryNumberFrom" placeholder="ID from" class="form-control">
                                <input type="text" name="categoryNumberTo" id="categoryNumberTo" placeholder="ID to" class="form-control">
                                <input type="text" name="categoryName" id="categoryName" placeholder="Name" class="form-control">
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
                            <form action="{{route('category.index')}}" method="get" class="form-inline justify-content-start" id="sort">
                                @csrf
                                @method('GET')
                                <select name="column" id="column" class="form-control">
                                    <option value="categoryNumber" selected>ID</option>
                                    <option value="categoryName">Title</option>
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
                            <a href="{{route('category.create')}}" class="btn btn-success">
                                <i class="material-icons">&#xE147;</i>
                                <span>Add</span>
                            </a>
                            <form action="{{route('category.destroy')}}" method="post" id="deleteForm">
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
                        <th></th>
                        <th>Name</th>
                        <th>Parent</th>
                        <th>Children</th>
                        <th>#Items</th>
                        <th class="text-center">Actions</th>
                    </tr>
                    </thead>

                    <tbody>

                    @if(count($boom) > 0)
                            @foreach($boom as $category)
                                @include('partials.category', ['category' => $category, 'prefix' => ''])
                            @endforeach
                    @else
                        @include('partials.categories-none')
                    @endif

                    </tbody>
                </table>

                <div class="clearfix">
                    <div class="hint-text">Showing <b>{{$pages->count()}}</b> out of <b>{{$pages->total()}}</b> entries</div>
                    {{$pages->onEachSide(3)->links()}}
                </div>
            </div>
        </div>
    </div>
@endsection





