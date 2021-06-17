@extends('backend.layouts.master')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Book</h1>
        <a href="{{route('admin.books.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus-circle fa-sm text-white-50"></i>Add New Book</a>
    </div>

    @include('backend.layouts.partials.messages')


    <!-- Content Row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Book List</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Sl:</th>
                                <th>Name:</th>
                                <th>Book Image</th>
                                <th>URL:</th>
                                <th>Category:</th>
                                <th>Publisher:</th>
                                <th>Statictis:</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Manage:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$book->title}}</td>
                                <td>
                                    <img src="{{asset('images/books/'.$book->image)}}" alt="{{$book->title}}" height="100px" width="100px">
                                </td>
                                <td><a href="{{route('books.show',$book->slug)}}" target="_blank">{{route('books.show',$book->slug)}}</a></td>
                                <td>{{$book->category->name}}</td>
                                <td>{{$book->publisher->name}}</td>
                                <td>
                                    <i class="fa fa-eye"></i>{{$book->total_view}} <br>
                                    <i class="fa fa-search"></i>{{$book->total_search}} <br>
                                    <i class="fa fa-file"></i>{{$book->total_borrowed}} <br>
                                </td>
                                <td>{{$book->description}}</td>
                                <td>
                                    @if(isset($approved))
                                    @if($approved==false)
                                    <form action="{{route('admin.books.approved',$book->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> Approved Now</button>
                                    </form>
                                    @else
                                    <form action="{{route('admin.books.unapproved',$book->id)}}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-check"></i> UnApproved Now</button>
                                    </form>
                                    @endif
                                    @else

                                    @if($book->is_approved)
                                    <span class="badge badge-success"><i class="fa fa-check"></i>Approved </span>
                                    @else
                                    <span class="badge badge-danger"><i class="fa fa-times"></i>Not Approved </span>
                                    @endif

                                    @endif
                                </td>
                                <td>
                                    <a href="{{route('admin.books.edit',$book->id)}}" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="#deleteModal{{$book->id}}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>


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
                                            <form action="{{route('admin.books.delete',$book->id)}}" method="POST">
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
                            @endforeach
                        </tbody>
                        <tfoot>
                            <th>Sl:</th>
                            <th>Name:</th>
                            <th>Book Image</th>
                            <th>URL:</th>
                            <th>Category:</th>
                            <th>Publisher:</th>
                            <th>Statictis:</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Manage:</th>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>
<!-- /.container-fluid -->





@endsection