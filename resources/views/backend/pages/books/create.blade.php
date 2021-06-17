@extends('backend.layouts.master')

@section('content')


<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Book</h1>
    </div>
    @include('backend.layouts.partials.messages')
    <div class="row">
        <div class="col-md-12">
            <form action="{{route('admin.books.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label for="title"> Book Title:</label>
                        <br>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Book Title">
                    </div>
                    <div class="col-md-6">
                        <label for="slug">Book URL Text:</label>
                        <br>
                        <input type="text" class="form-control" name="slug" id="slug" placeholder="Enter Book  URL, e.g:C-Programming">
                    </div><br>
                    <div class="col-md-6">
                        <label for="category_id">Book Category:</label>
                        <br>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="col-md-6">
                        <label for="isbn"> Book Isbn:</label>
                        <br>
                        <input type="text" class="form-control" name="isbn" id="isbn" placeholder="Enter Book ISBN">
                    </div>
                    <div class="col-md-6">
                        <label for="author_id">Book Author:</label>
                        <br>
                        <select name="author_id[]" id="author_id" class="form-control select2" multiple>
                            <option value="">Select Author</option>
                            @foreach($authors as $author)
                            <option value="{{$author->id}}">{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="col-md-6">
                        <label for="publisher_id">Book Publisher:</label>
                        <br>
                        <select name="publisher_id" id="publisher_id" class="form-control">
                            <option value="">Select Publisher</option>
                            @foreach($publishers as $publisher)
                            <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="col-md-6">
                        <label for="publish_year">Book Publication Year:</label>
                        <br>
                        <select name="publish_year" id="publish_year" class="form-control">
                            <option value="">Select Publication Year</option>
                            @for($year = date('Y'); $year >=1900; $year--)
                            <option value="{{$year}}">{{$year}}</option>
                            @endfor
                        </select>
                    </div><br>
                    <div class="col-md-6">
                        <label for="quantity">Book Feature Image:</label>
                        <br>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Enter Book Feature Image">
                    </div>
                    <div class="col-md-6">
                        <label for="translator_id">Book Translator:</label>
                        <br>
                        <select name="translator_id" id="translator_id" class="form-control select2" multiple>
                            <option value="">Select Translator Book</option>
                            @foreach($books as $book)
                            <option value="{{$book->id}}">{{$book->title}}</option>
                            @endforeach
                        </select>
                    </div><br>
                    <div class="col-md-6">
                        <label for="image">Book Quantity:</label>
                        <br>
                        <input type="number" class="form-control" value="1" min="1" name="quantity" id="quantity" placeholder="Enter Book Quantity" required>
                    </div><br>
                    <div class="col-md-12">
                        <label for="description">Book Description:</label>
                        <br>
                        <textarea class="form-control" name="description" id="summernote" placeholder="Book Description" cols="30" rows="5"></textarea>
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
@endsection