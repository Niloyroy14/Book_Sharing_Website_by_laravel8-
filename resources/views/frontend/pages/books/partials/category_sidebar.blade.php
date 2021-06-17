<div class="list-group mt-3">
    @foreach(App\Models\Category::all() as $category)
    <a href="{{route('categories.show',$category->slug)}}" class="list-group-item list-group-item-action">
        {{$category->slug}}
    </a>
    @endforeach
</div>