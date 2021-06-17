@extends('backend.layouts.master')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Publishers</h1>
        <a href="#addModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i>Add Publisher</a>
    </div>

    @include('backend.layouts.partials.messages')
    <!--Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Publisher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.publishers.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Publisher Name:</label>
                                <br>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Publisher Name">
                            </div>
                            <div class="col-md-6">
                                <label for="link">Publisher Link:</label>
                                <br>
                                <input type="text" class="form-control" name="link" id="link" placeholder="Enter Publisher Link">
                            </div><br><br><br>
                            <div class="col-md-6">
                                <label for="address">Publisher Address:</label>
                                <br>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Enter Publisher Address">
                            </div><br>
                            <div class="col-md-6">
                                <label for="outlet">Publisher Outlel:</label>
                                <br>
                                <input type="text" class="form-control" name="outlet" id="outlet" placeholder="Enter Publisher Outlet">
                            </div><br><br><br>
                            <div class="col-md-12">
                                <label for="summernote">Publisher Description:</label>
                                <br>
                                <textarea id="summernote" class="form-control" name="description" placeholder="Enter Publisher Description" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Content Row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Publisher List</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Sl:</th>
                                <th>Name:</th>
                                <th>Link:</th>
                                <th>Address</th>
                                <th>Outlet</th>
                                <th>Description:</th>
                                <th>Manage:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($publishers as $publisher)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$publisher->name}}</td>
                                <td>{{$publisher->link}}</td>
                                <td>{{$publisher->address}}</td>
                                <td>{{$publisher->description}}</td>
                                <td>
                                    <a href="#editModal{{$publisher->id}}" data-toggle="modal" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="#deleteModal{{$publisher->id}}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>


                            <!--Edit Modal -->
                            <div class="modal fade" id="editModal{{$publisher->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit publisher</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.publishers.update',$publisher->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="name">Publisher Name:</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="name" id="name" value="{{$publisher->name}}">
                                                        <br>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="name">Publisher Link:</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="link" id="link" value="{{$publisher->link}}">
                                                    </div><br><br><br>
                                                    <div class="col-md-6">
                                                        <label for="name">Publisher Address:</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="address" id="address" value="{{$publisher->address}}">
                                                    </div><br>
                                                    <div class="col-md-6">
                                                        <label for="name">Publisher Outlel:</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="outlet" id="outlet" value="{{$publisher->outlet}}">
                                                    </div><br><br><br>
                                                    <div class="col-md-12">
                                                        <label for="summernote">Publisher Description:</label>
                                                        <br>
                                                        <textarea class="form-control" name="description" id="summernote" cols="30" rows="5">{{$publisher->description}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!--Delete Modal -->
                            <div class="modal fade" id="deleteModal{{$publisher->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are You Sure to Delete?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.publishers.delete',$publisher->id)}}" method="POST">
                                                @csrf
                                                <div>
                                                    <p>{{$publisher->name}} will be Deleted</p>
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
                            <th>Link:</th>
                            <th>Address</th>
                            <th>Outlet</th>
                            <th>Description:</th>
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