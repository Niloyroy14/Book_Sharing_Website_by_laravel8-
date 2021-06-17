@extends('frontend.layouts.master')

@section('content')


<div class="main-content">

  <div class="login-area page-area">
    <div class="container">
      <div class="row">
        <div class="col-md-12 p-1">
          <div class="profile-tab border p-2">
            <h3>User: {{$users->name}}</h3>
            <br>
            <strong>Uploaded Books</strong>
            <hr>
            @include('frontend.pages.books.partials.booklist')
            <div class="books-pagination mt-5">
              {{$books->links()}}
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