<div class="row">
    @foreach($books as $book)
    <div class="col-md-4">
        <div class="single-book">
            <img src="{{asset('images/books/'.$book->image)}}" alt="{{$book->title}}">
            <div class="book-short-info">
                <h5>{{$book->title}}</h5>
                <p>
                    <a href="{{route('users.profile',$book->user->user_name)}}" class=""><i class="fa fa-upload"></i>
                        {{$book->user->name}}
                    </a>
                </p>

                @if(Route::is('users.dashboards.books'))

                <a href="{{route('books.show',$book->id)}}" class="btn btn-outline-primary"><i class="fa fa-eye"></i></a>
                <a href="{{route('users.dashboards.books.edit',$book->id)}}" class="btn btn-outline-primary"><i class="fa fa-edit"></i></a>
                <a href="#deleteModal{{$book->id}}" data-toggle="modal" class="btn btn-outline-danger"><i class="fa fa-trash"></i></a>
                <!--Delete Modal -->
                <div class="modal fade" id="deleteModal{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are You Sure to Delete?</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('users.dashboards.books.delete',$book->id)}}" method="POST">
                                    @csrf
                                    <div>
                                        <p>{{$book->title}} will be Deleted</p>
                                    </div>
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <a href="{{route('books.show',$book->id)}}" class="btn btn-outline-primary"><i class="fa fa-eye"></i> View</a>
                {{--<a href="" class="btn btn-outline-danger"><i class="fa fa-heart"></i> Wishlist</a> --}}
                @endif
            </div>
        </div>
    </div> <!-- Single Book Item -->
    @endforeach
</div>