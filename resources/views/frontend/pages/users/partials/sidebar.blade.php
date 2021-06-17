<div class="profile-sidebar border">
    <div class="widget">
        <h5 class="mb-2 border-bottom pb-3">
            <i class="fa fa-user default-user"></i>
        </h5>

        <div class="list-group mt-3">
            <a href="{{route('users.profile',Auth::user()->user_name)}}" class="list-group-item list-group-item-action">
                Profile
            </a>
            <a href="{{route('users.dashboards')}}" class="list-group-item list-group-item-action">
                Dashboard
            </a>
            <a href="{{route('users.dashboards.books')}}" class="list-group-item list-group-item-action">
                My Uploaded Books
            </a>
            <a href="{{route('books.order.list')}}" class="list-group-item list-group-item-action">
                My Ordered Books
            </a>
            <a href="{{route('books.request.list')}}" class="list-group-item list-group-item-action">
                My Requests
            </a>
        </div>

    </div> <!-- Single Widget -->
</div>