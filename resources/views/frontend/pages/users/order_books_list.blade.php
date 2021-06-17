@extends('frontend.layouts.master')

@section('content')


<div class="main-content">

    <div class="login-area page-area">
        <div class="container">
            <div class="row">
                <div class="col-md-8 p-1">
                    <div class="profile-tab border p-2">
                        <h3 class="">My Ordered Books</h3>
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
                                    @foreach($book_order as $order)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td> <a href="{{route('books.show',$order->book->id)}}"> {{$order->book->title}} </a></td>
                                        <td>
                                            {{$order->owner->name}}
                                            <br>
                                            {{$order->owner->phone_no}}
                                        </td>
                                        <td>{{$order->owner_message}}</td>
                                        <td>
                                            @if($order->status==1)
                                            <span class="badge badge-pill badge-primary"> Request Sent</span>
                                            @elseif($order->status==2)
                                            <span class="badge badge-pill badge-success">Owner Approved</span>
                                            @elseif($order->status==3)
                                            <span class="badge badge-pill badge-danger">Owner Rejected</span>
                                            @elseif($order->status==4)
                                            <span class="badge badge-pill badge-success">Confirmed</span>
                                            @elseif($order->status==5)
                                            <span class="badge badge-pill badge-danger"> Rejected</span>
                                            @endif

                                            @if($order->status==2)
                                            <form action="{{route('books.order.approve',$order->id)}}" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approve</button>
                                            </form>

                                            <form action="{{route('books.order.reject',$order->id)}}" method="post" class="mt-1">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">Reject</button>
                                            </form>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$book_order->links()}}
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