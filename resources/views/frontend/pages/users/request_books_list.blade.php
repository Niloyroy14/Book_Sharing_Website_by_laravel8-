@extends('frontend.layouts.master')

@section('content')


<div class="main-content">

    <div class="login-area page-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 p-1">
                    <div class="profile-tab border p-2">
                        <h3 class="">My Requested Books</h3>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Book Title</th>
                                        <th>Requester</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($book_request as $request)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td> <a href="{{route('books.show',$request->book->id)}}"> {{$request->book->title}} </a></td>
                                        <td>
                                            {{$request->user->name}}
                                            <br>
                                            {{$request->user->phone_no}}
                                        </td>
                                        <td>{{$request->user_message}}</td>
                                        <td>
                                            @if($request->status==1)
                                            <span class="badge badge-pill badge-primary"> Request Sent</span>
                                            @elseif($request->status==2)
                                            <span class="badge badge-pill badge-success">Request Approved</span>
                                            @elseif($request->status==3)
                                            <span class="badge badge-pill badge-danger">Request Rejected</span>
                                            @elseif($request->status==4)
                                            <span class="badge badge-pill badge-success">User Confirm</span>
                                            @elseif($request->status==5)
                                            <span class="badge badge-pill badge-danger">User Rejected</span>
                                            @elseif($request->status==6)
                                            <span class="badge badge-pill badge-info">Return Request</span>
                                            @elseif($request->status==7)
                                            <span class="badge badge-pill badge-success">Return Confirmed</span>
                                            @endif

                                            @if($request->status==1)
                                            <form action="{{route('books.request.approve',$request->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>

                                            <form action="{{route('books.request.reject',$request->id)}}" method="post" class="mt-1">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                            @elseif($request->status==2)
                                            <form action="{{route('books.request.reject',$request->id)}}" method="post" class="mt-1">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                            @elseif($request->status==3)
                                            <form action="{{route('books.request.approve',$request->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>
                                            @elseif($request->status==6)
                                            <form action="{{route('books.return.confirm',$request->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Confirm Return</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$book_request->links()}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-1">
                    @include('frontend.pages.users.partials.sidebar')
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