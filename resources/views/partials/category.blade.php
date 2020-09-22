
<tr>
    <td>
        <span class="custom-checkbox">
            <input type="checkbox" name="checkbox" id="{{$category->categoryNumber}}">
            <label for="{{$category->categoryNumber}}"></label>
        </span>
    </td>
    <td>{{$category->categoryNumber}}</td>
    <td style="width: 5%;">
    <form action="{{route('category.update', $category->categoryNumber)}}" method="post">
        @csrf
        @method('PUT')
        <button class="btn bmd-btn-icon" type="submit" name="action" value="visible">
            <i class="material-icons" title="Auctions">&#xE313;</i>
        </button>
    </form>
    </td>
    <td>{{$prefix}}{{$category->categoryName}}</td>
    @if($category->categoryParent == 0)
        <td>ROOT</td>
        @else
        <td>{{$category->categoryParent}}</td>
    @endif
    <td>
        @foreach($category->categoryChildren as $index => $categoryChild)
            {{$categoryChild->categoryNumber}}
        @endforeach
    </td>
    <td>{{$category->categoryNumberOfItems}}</td>

<td class="d-flex">
    <form action="{{route('category.edit', $category->categoryNumber)}}" method="get">
        @csrf
        @method('GET')
        <button class="btn bmd-btn-icon" type="submit" >
            <i class="material-icons edit" title="Edit">&#xE254;</i>
        </button>
    </form>
    <form action="{{route('category.destroy', $category->categoryNumber)}}" method="post">
        @csrf
        @method('DELETE')
        <button class="btn bmd-btn-icon" type="submit">
            <i class="material-icons delete" title="Delete">&#xE872;</i>
        </button>
    </form>
</td>
</tr>


@if(count($category->categoryChildren) > 0 && $category->categoryVisible)
<tr>
    @foreach($category->categoryChildren as $category)
        @include('partials.category', ['category' => $category, 'prefix' => $prefix.'- '])
    @endforeach
</tr>
@endif
