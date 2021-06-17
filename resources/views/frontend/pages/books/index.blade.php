@extends('frontend.layouts.master')

@section('content')


<div class="main-content">
  <div class="book-list-sidebar">
    <div class="container">
      <div class="row">

        <div class="col-md-9">
          <h3>
            @if(isset($search))
            Searched Books By - <mark>{{$search}} </mark>
            @else
            @if(Route::is('categories.show'))
            <mark>{{$category->name}} </mark> Category Books
            @else
            Recent Uploaded Books
            @endif
            @endif
          </h3>

          @include('frontend.pages.books.partials.booklist')

          <div class="books-pagination mt-5">
            {{$books->links()}}
          </div>

        </div> <!-- Book List -->

        <div class="col-md-3">
          <div class="widget">
            <h5 class="mb-2 border-bottom pb-3">
              Categories
            </h5>

            @include('frontend.pages.books.partials.category_sidebar')

          </div> <!-- Single Widget -->

        </div> <!-- Sidebar -->

      </div>
    </div>
  </div>

</div>




@endsection