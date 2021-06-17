@extends('frontend.layouts.master')


@section('styles')
<!-- Select2 styles for select multiple author -->
<link href="{{asset('admin/css/select2.min.css')}}" rel="stylesheet">

<!-- Summer Note Text Editor  styles for Book Details -->
<link href="{{asset('admin/css/summernote.css')}}" rel="stylesheet">
@endsection

@section('content')

<div class="main-content">

    <div class="book-show-area">
        <div class="container">
            <h3>Edit Your Book</h3>
            <div class="row">
                <div class="col-md-12">
                    <form action="{{route('users.dashboards.books.update',$book->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="title"> Book Title:</label>
                                <br>
                                <input type="text" class="form-control" name="title" id="title" value="{{$book->title}}">
                            </div>
                            <div class="col-md-6">
                                <label for="slug">Book URL Text:</label>
                                <br>
                                <input type="text" class="form-control" name="slug" id="slug" value="{{$book->slug}}">
                            </div><br>
                            <div class="col-md-6">
                                <label for="category_id">Book Category:</label>
                                <br>
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{$book->category_id == $category->id ? 'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="isbn"> Book Isbn:</label>
                                <br>
                                <input type="text" class="form-control" name="isbn" id="isbn" value="{{$book->isbn}}" placeholder="Enter Book ISBN">
                            </div>
                            <div class="col-md-6">
                                <label for="author_id">Book Author:</label>
                                <br>
                                <select name="author_id[]" id="author_id" class="form-control select2" multiple>
                                    <option value="">Select Author</option>
                                    @foreach($authors as $author)
                                    <option value="{{$author->id}}" {{App\Models\Book::isAuthorSelected($book->id,$author->id) ? 'selected':''}}>{{$author->name}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="publisher_id">Book Publisher:</label>
                                <br>
                                <select name="publisher_id" id="publisher_id" class="form-control">
                                    <option value="">Select Publisher</option>
                                    @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}" {{$book->publisher_id == $publisher->id ? 'selected' : ''}}>{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="publish_year">Book Publication Year:</label>
                                <br>
                                <select name="publish_year" id="publish_year" class="form-control">
                                    <option value="">Select Publication Year</option>
                                    @for($year = date('Y'); $year >=1900; $year--)
                                    <option value="{{$year}}" {{$book->publish_year == $year ? 'selected' : ''}}>{{$year}}</option>
                                    @endfor
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="image">Book Feature Old Image:</label>
                                <br>
                                <img src="{{asset('images/books/'.$book->image)}}" alt="{{$book->title}}" height="100px" width="100px">
                                <br>
                                <br>
                                <label for="image">Update Book Feature Image:</label>
                                <input type="file" class="form-control" name="image" id="image" placeholder="Enter Book Title">
                            </div>
                            <div class="col-md-6">
                                <label for="translator_id">Book Translator:</label>
                                <br>
                                <select name="translator_id" id="translator_id" class="form-control select2" multiple>
                                    <option value="">Select Translator Book</option>
                                    @foreach($books as $tranl_book)
                                    <option value="{{$tranl_book->id}}" {{ $book->translator_id == $tranl_book->id ? 'selected' : '' }}>{{$tranl_book->title}}</option>
                                    @endforeach
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="image">Book Quantity:</label>
                                <br>
                                <input type="number" class="form-control" name="quantity" id="quantity" value="{{$book->quantity}}" min="1" required>
                            </div><br>
                            <div class="col-md-12">
                                <label for="summernote">Book Description:</label>
                                <br>
                                <textarea class="form-control" name="description" id="summernote" cols="30" rows="5">{!! $book->description !!}</textarea>
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

</div>


@endsection


@section('scripts')
<!-- Select2 scripts for multiple author-->
<script src="{{asset('admin/js/select2.min.js')}}"></script>

<!-- Summer Note Text Editor scripts for book details-->
<script src="{{asset('admin/js/summernote.js')}}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        $('#summernote').summernote();
    });
</script>

@endsection