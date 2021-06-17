<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookAuthor;
use App\Models\BookRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DashboardsController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$username = Auth::user()->user_name;
        //$users = User::where('user_name', $username)->first();
        $users = Auth::user();
        if (!is_null($users)) {
            return view('frontend.pages.users.dashboard', compact('users'));
        }
        return redirect()->route('index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function books()
    {
        $user = Auth::user();

        if (!is_null($user)) {
            $books = $user->books()->paginate(5);
            return view('frontend.pages.users.dashboard_books', compact('user', 'books'));
        }
        return redirect()->route('index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::find($id);

        $books      = Book::where('is_approved', 1)->where('id', '!=', $id)->get();
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors    = Author::all();

        return view('frontend.pages.users.editbook', compact('books', 'categories', 'publishers', 'authors', 'book'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $book = Book::find($id);

        $request->validate(
            [
                'title'        => 'required|max:50',
                'category_id'  => 'required',
                'publisher_id' => 'required',
                'slug'         => 'nullable|unique:books,slug,' . $book->id,
                'description'  => 'nullable',
                'image'        => 'nullable|image|max:4048'
            ],
            [
                'title.required' => 'Please give a book Title',
                'image.max'  => 'Image Size can not be greater than 4 MB'
            ]
        );

        $book->title         = $request->title;
        if (empty($request->slug)) {
            $book->slug = Str::slug($request->title);
        } else {
            $book->slug = $request->slug;
        }
        $book->category_id   = $request->category_id;
        $book->isbn          = $request->isbn;
        $book->quantity      = $request->quantity;
        $book->publisher_id  = $request->publisher_id;
        $book->translator_id = $request->translator_id;
        $book->publish_year  = $request->publish_year;
        $book->description   = $request->description;

        $book->save();

        //image update without use imageIntervention package

        if ($request->image) {

            //delete the old image from the folder
            if (File::exists('images/books/' . $book->image)) {
                File::delete('images/books/' . $book->image);
            }

            //insert the new image
            $file = $request->file('image');
            $ext  = $file->getClientOriginalExtension();
            $name = time() . '-' . $book->id . '.' . $ext;
            $path = "images/books";
            $file->move($path, $name);

            $book->image = $name;
            $book->save();
        }


        //Book Author
        //Delete Old Authors Table data
        $book_author = BookAuthor::where('book_id', $book->id)->get();

        foreach ($book_author  as $author) {
            $author->delete();
        }
        //update the Author
        foreach ($request->author_id as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id    =  $book->id;
            $book_author->author_id  =  $id;
            $book_author->save();
        }

        session()->flash('success', 'Book Has Been Updated');
        return redirect()->route('users.dashboards.books');
    }




    /**
     * requestBook the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requestBook(Request $request, $id)
    {

        $request->validate(
            [
                'user_message'        => 'required|max:3000',
            ],
            [
                'user_message.required' => 'Please Write Your Message to Request for the Book !!'
            ]
        );

        $book = Book::find($id);

        if (!is_null($book)) {

            $book_request = new BookRequest();

            $book_request->user_id = Auth::id();
            $book_request->owner_id = $book->user_id;
            $book_request->book_id = $book->id;
            $book_request->status = 1;
            $book_request->user_message = $request->user_message;
            $book_request->save();

            session()->flash('success', 'Book Has Been requested to the user');
            return back();
        } else {
            session()->flash('error', 'No Book Found !!');
            return back();
        }
    }


    /**
     * requestUpdateBook the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requestUpdateBook(Request $request, $id)
    {

        $request->validate(
            [
                'user_message'        => 'required|max:3000',
            ],
            [
                'user_message.required' => 'Please Write Your Message to Request for the Book !!'
            ]
        );


        $book_request = BookRequest::find($id);

        if (!is_null($book_request)) {

            $book_request->user_message = $request->user_message;
            $book_request->save();

            session()->flash('success', 'Book request Has Been Updated and send to the user');
            return back();
        } else {
            session()->flash('error', 'No Request Has not Been Updated !!');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function requestdeleteBook($id)
    {
        $book_request = BookRequest::find($id);

        if (!is_null($book_request)) {
            $book_request->delete();
        }
        session()->flash('success', 'Book Requested Has Been Canceled !!');
        return back();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  requestBookList()    // request to other user who owner of the book
    {
        $user = Auth::user();

        if (!is_null($user)) {
            $book_request = BookRequest::where('owner_id', $user->id)->orderBy('id', 'desc')->paginate(10);
            return view('frontend.pages.users.request_books_list', compact('user', 'book_request'));
        }
        return redirect()->route('index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestBookApprove($id)    // request to other user who owner of the book
    {
        $book_request = BookRequest::find($id);

        if (!is_null($book_request)) {

            $book_request->status = 2; //confirmed by owner
            $book_request->save();

            session()->flash('success', 'Book request Has Been Approved by the user');
            return back();
        } else {
            session()->flash('error', 'Book Request Has not Been Approved !!');
            return back();
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function requestBookReject($id)    // request to other user who owner of the book
    {
        $book_request = BookRequest::find($id);

        if (!is_null($book_request)) {

            $book_request->status = 3; //Rejected by owner
            $book_request->save();

            session()->flash('success', 'Book request Has Been Rejected  by the user');
            return back();
        } else {
            session()->flash('error', 'Book Request Has not Been Rejected !!');
            return back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  orderBookList()    // request to other user who owner of the book
    {
        $user = Auth::user();

        if (!is_null($user)) {
            $book_order = BookRequest::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(10);
            return view('frontend.pages.users.order_books_list', compact('user', 'book_order'));
        }
        return redirect()->route('index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderBookApprove($id)    // request to other user who owner of the book
    {
        $book_order = BookRequest::find($id);

        if (!is_null($book_order)) {

            $book_order->status = 4; //confirmed by user
            $book_order->save();

            $book = Book::find($book_order->book_id);
            $book->decrement('quantity');

            session()->flash('success', 'Book Order Has Been Return by the user');
            return back();
        } else {
            session()->flash('error', 'Book Order Has not Been Return !!');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderBookReject($id)    // request to other user who owner of the book
    {
        $book_order = BookRequest::find($id);

        if (!is_null($book_order)) {

            $book_order->status = 5; //Rejected by user
            $book_order->save();

            session()->flash('success', 'Book Order Has Been Rejected  by the user');
            return back();
        } else {
            session()->flash('error', 'Book Order Has not Been Rejected !!');
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderBookReturn($id)    // request to other user who owner of the book
    {
        $book_order = BookRequest::find($id);

        if (!is_null($book_order)) {

            $book_order->status = 6; //Return by user
            $book_order->save();

            session()->flash('success', 'Book Order Has Been Returned by the user');
            return back();
        } else {
            session()->flash('error', 'Book Order Has not Been Returned !!');
            return back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function orderBookReturnConfirm($id)    // request to other user who owner of the book
    {
        $book_order = BookRequest::find($id);

        if (!is_null($book_order)) {

            $book_order->status = 7; //Returned Confirmed by owner
            $book_order->save();

            $book = Book::find($book_order->book_id);
            $book->increment('quantity');

            session()->flash('success', 'Book Order Has Been Returned Successfully !!');
            return back();
        } else {
            session()->flash('error', 'Book Order Has not Been Returned Successfully !!');
            return back();
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!is_null($book)) {
            //delete the old image from the folder
            if (!is_null($book->image)) {
                if (File::exists('images/books/' . $book->image)) {
                    File::delete('images/books/' . $book->image);
                }
            }

            $book_authors = BookAuthor::where('book_id', $book->id)->get();
            foreach ($book_authors as $book_author) {
                $book_author->delete();
            }
            $book->delete();
        }

        session()->flash('success', 'Book Has Been Deleted');
        return back();
    }
}
