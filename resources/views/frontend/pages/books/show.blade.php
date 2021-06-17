@extends('frontend.layouts.master')

@section('content')


<div class="main-content">
  <div class="book-show-area">
    <div class="container">
      @include('frontend.layouts.partials.messages')
      <div class="row">
        <div class="col-md-3">
          <img src="{{asset('images/books/'.$book->image)}}" alt="{{$book->title}}" class="img img-fluid" />
        </div>
        <div class="col-md-9">
          <h3>{{$book->title}}</h3>
          <p class="text-muted">Written By
            <span class="text-primary">niloy</span> @<span class="text-info">Programming</span>
          </p>
          <hr>
          <p><strong>Uploaded By: </strong>{{$book->user->name}}</p>
          <p><strong>Uploaded at: </strong> 2 months ago</p>
          <p><strong>Publisher at: </strong>{{$book->publish_year}},<strong>Publisher: </strong>{{$book->publisher->name}},<strong>ISBN: </strong>{{$book->isbn}}</p>
          <div class="book-description">
            {{$book->description}}
          </div>

          <div class="book-buttons mt-4">
            <!-- <a href="" class="btn btn-outline-success"><i class="fa fa-check"></i> Already Read</a>
            <a href="book-view.html" class="btn btn-outline-warning"><i class="fa fa-cart-plus"></i> Add to Cart</a>
            <a href="" class="btn btn-outline-danger"><i class="fa fa-heart"></i> Add to Wishlist</a> -->

            @auth

            @if($book->quantity>0) //check the quantity

            @if(!is_null(App\Models\User::bookRequest($book->id)))
            @if(App\Models\User::bookRequest($book->id)->status == 1)
            <span class="badge badge-success" style="padding:12px;border-radius:0px;font-size:14px;">
              <i class="fa fa-check">Already Requested</i>
            </span>
            @elseif(App\Models\User::bookRequest($book->id)->status == 2)
            <span class="badge badge-info" style="padding:12px;border-radius:0px;font-size:14px;">
              <i class="fa fa-check">Owner Confirmed</i>
            </span>
            @elseif(App\Models\User::bookRequest($book->id)->status == 3)
            <span class="badge badge-danger" style="padding:12px;border-radius:0px;font-size:14px;">
              <i class="fa fa-check">Owner Rejected</i>
            </span>
            @elseif(App\Models\User::bookRequest($book->id)->status == 4)
            <span class="badge badge-success" style="padding:12px;border-radius:0px;font-size:14px;">
              <i class="fa fa-check">Reading</i>
            </span>
            @endif

            @if(App\Models\User::bookRequest($book->id)->status == 4)

            <a href="#returnBookModal{{ $book->id}}" class="btn btn-outline-warning" data-toggle="modal"><i class="fa fa-arrow-right"></i>Return Book</a>
            <!--return Book Modal -->
            <div class="modal fade" id="returnBookModal{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Return <mark>{{$book->title}}</mark> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('books.return.store',App\Models\User::bookRequest($book->id)->id)}}" method="POST">
                      @csrf
                      <div>
                        <p>Are you sure to return the Book?</p>
                      </div>
                      <button type="submit" class="btn btn-success mt-4"> <i class="fa fa-send"></i> Send Return Request </button>
                      <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @if(App\Models\User::bookRequest($book->id)->status == 1)
            <a href="#requestUpdateModal{{ $book->id}}" class="btn btn-outline-success" data-toggle="modal"><i class="fa fa-check"></i> Update Request</a>
            <form action="{{route('books.request.delete',App\Models\User::bookRequest($book->id)->id)}}" method="post" style="display:inline-block;">
              @csrf
              <button type="submit" class="btn btn-danger"> <i class="fa fa-times"></i> Cancel Request</button>
            </form>
            <!--Request Update Modal -->
            <div class="modal fade" id="requestUpdateModal{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Request For <mark>{{$book->title}}</mark> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('books.request.update',App\Models\User::bookRequest($book->id)->id)}}" method="POST">
                      @csrf
                      <div>
                        <p>Update a request to the Owner of Book?</p>
                        <textarea name="user_message" id="user_message" class="form-control" rows="5" placeholder="Enter Your Password to the Owner (Keep empty there is no Message)">{{App\Models\User::bookRequest($book->id)->user_message}}</textarea>
                      </div>
                      <button type="submit" class="btn btn-success mt-4"> <i class="fa fa-send"></i> Update Request Now</button>
                      <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            @endif

            @else
            <a href="#requestModal{{ $book->id}}" class="btn btn-outline-success" data-toggle="modal"><i class="fa fa-check"></i> Send Request</a>
            @endif

            @else
            <span class="badge badge-info" style="padding:12px;border-radius:0px;font-size:14px;">Someone is Reading This Book ....</span>
            @endif
            @endauth

            <!--Request Modal -->
            <div class="modal fade" id="requestModal{{$book->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Request For <mark>{{$book->title}}</mark> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form action="{{route('books.request',$book->id)}}" method="POST">
                      @csrf
                      <div>
                        <p>Send a request to the Owner of Book?</p>
                        <textarea name="user_message" id="user_message" class="form-control" rows="5" placeholder="Enter Your Password to the Owner (Keep empty there is no Message)"></textarea>
                      </div>
                      <button type="submit" class="btn btn-success mt-4"> <i class="fa fa-send"></i> Send Request Now</button>
                      <button type="button" class="btn btn-secondary mt-4" data-dismiss="modal">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-5">
      </div>
      <div class="row mt-5">
      </div>
      <div class="row mt-5">
      </div>
    </div>
  </div>

</div>





@endsection