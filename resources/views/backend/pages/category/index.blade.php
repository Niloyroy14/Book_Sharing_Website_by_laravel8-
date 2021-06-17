@extends('backend.layouts.master')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Category</h1>
        <a href="#addModal" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addModal"><i class="fas fa-plus-circle fa-sm text-white-50"></i>Add Category</a>
    </div>

    @include('backend.layouts.partials.messages')
    <!--Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.category.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Category Name:</label>
                                <br>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name">
                            </div>
                            <div class="col-md-6">
                                <label for="slug">Category URL Text:</label>
                                <br>
                                <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter Category Slug, e.g:C-Programming">
                            </div><br><br><br>
                            <div class="col-md-6">
                                <label for="parent_id">Parent Category:</label>
                                <br>
                                <select name="parent_id" id="parent_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($parent_categories as $parent_category)
                                    <option value="{{$parent_category->id}}">{{$parent_category->name}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-12">
                                <label for="description">Category Description:</label>
                                <br>
                                <textarea class="form-control" name="description" id="summernote" placeholder="Enter Category Description" cols="30" rows="5"></textarea>
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
                    <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
                </div>
                <div class="card-body">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Sl:</th>
                                <th>Name:</th>
                                <th>Slug:</th>
                                <th>Description:</th>
                                <th>Parent Id </th>
                                <th>Manage:</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$category->name}}</td>
                                <td><a href="{{route('categories.show',$category->slug)}}" target="_blank">{{route('categories.show',$category->slug)}}</a></td>
                                <td>{{$category->description}}</td>
                                <td>
                                    @if(!is_null($category->parent_id))
                                    {{$category->parentCategory->name}}
                                    @else
                                    --
                                    @endif
                                </td>
                                <td>
                                    <a href="#editModal{{$category->id}}" data-toggle="modal" class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                    <a href="#deleteModal{{$category->id}}" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>


                            <!--Edit Modal -->
                            <div class="modal fade" id="editModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit category</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.category.update',$category->id)}}" method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="name">Category Name:</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="name" id="name" value="{{$category->name}}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="slug">Category URL Text(e.g:C-Programming):</label>
                                                        <br>
                                                        <input type="text" class="form-control" name="slug" id="slug" value="{{$category->slug}}">
                                                    </div><br><br><br>
                                                    <div class="col-md-6">
                                                        <label for="parent_id">Parent Category:</label>
                                                        <br>
                                                        <select name="parent_id" id="parent_id" class="form-control">
                                                            <option value="">Select Category</option>
                                                            @if(!is_null($category->parent_id))
                                                            @foreach($parent_categories as $parent_category)
                                                            <option value="{{$parent_category->id}}" {{$category->parent_id == $parent_category->id ? 'selected':'' }}>{{$parent_category->name}}</option>
                                                            @endforeach
                                                            @else
                                                            <option value="">Parent Category</option>
                                                            @endif
                                                        </select>
                                                    </div><br>
                                                    <div class="col-md-12">
                                                        <label for="description">Category Description:</label>
                                                        <br>
                                                        <textarea class="form-control" name="description" id="summernote" cols="30" rows="5">{{$category->description}}</textarea>
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
                            <div class="modal fade" id="deleteModal{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Are You Sure to Delete?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.category.delete',$category->id)}}" method="POST">
                                                @csrf
                                                <div>
                                                    <p>{{$category->name}} will be Deleted</p>
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
                            <th>Slug:</th>
                            <th>Description:</th>
                            <th>Parent Id </th>
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