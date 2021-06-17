<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;

use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookAuthor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::orderby('id', 'desc')->where('is_approved', 1)->paginate(10);
        return view('frontend.pages.books.index', compact('books'));
    }

    /**
     * Display a listing of the resource of
     *
     * @return \Illuminate\Http\Response
     */
    public function home_index()   //pagescontroller
    {
        $categories = Category::all();
        $publishers = Publisher::all();
        $books = Book::orderby('id', 'desc')->where('is_approved', 1)->paginate(10);
        return view('frontend.pages.index', compact('books', 'categories', 'publishers'));
    }

    /**
     * Display a searching of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->search;
        if (empty($search)) {
            return $this->home_index();
        }
        $books   = Book::orderby('id', 'desc')->where('is_approved', 1)->where('title', 'like', '%' . $search . '%')->orwhere('description', 'like', '%' . $search . '%')->paginate(10);
        return view('frontend.pages.books.index', compact('books', 'search'));
    }


    /**
     * Display a advanceSearch of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function advanceSearch(Request $request)
    {
        $search_title     = $request->title;
        $search_publisher = $request->publisher;
        $search_category  = $request->category;

        if (empty($search_title) && empty($search_publisher) && empty($search_category)) {
            return $this->home_index();
        }

        if (empty($search_title) && empty($search_category)) {
            $books   = Book::orderby('id', 'desc')->where('is_approved', 1)
                ->where('publisher_id', $search_publisher)
                ->paginate(10);
        } elseif (empty($search_title) && empty($search_publisher)) {
            $books   = Book::orderby('id', 'desc')->where('is_approved', 1)
                ->where('category_id',  $search_category)
                ->paginate(10);
        } else {
            $books   = Book::orderby('id', 'desc')->where('is_approved', 1)->where('title', 'like', '%' .  $search_title . '%')
                ->orwhere('description', 'like', '%' .  $search_title . '%')
                ->orwhere('category_id',  $search_category)
                ->orwhere('publisher_id', $search_publisher)
                ->paginate(10);
        }

        return view('frontend.pages.books.index', compact('books', 'search_title'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books      = Book::where('is_approved', 1)->get();
        $categories = Category::all();
        $publishers = Publisher::all();
        $authors    = Author::all();

        return view('frontend.pages.books.create', compact('books', 'categories', 'publishers', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized Action');
        }


        $request->validate(
            [
                'title'        => 'required|max:50',
                'category_id'  => 'required',
                'publisher_id' => 'required',
                'slug'         => 'nullable|unique:books',
                'description'  => 'nullable',
                'image'        => 'required|image|max:4048'
            ],
            [
                'title.required' => 'Please give a book Title',
                'image.max'  => 'Image Size can not be greater than 4 MB'
            ]
        );

        $book = new Book();

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
        //$book->is_approved  = 1;
        $book->user_id  = Auth::id();
        $book->save();

        //image upload without use imageIntervention package

        if ($request->image) {
            $file = $request->file('image');
            $ext  = $file->getClientOriginalExtension();
            $name = time() . '-' . $book->id . '.' . $ext;
            $path = "images/books";
            $file->move($path, $name);

            $book->image = $name;
            $book->save();
        }


        //Book Author

        foreach ($request->author_id as $id) {
            $book_author = new BookAuthor();
            $book_author->book_id    =  $book->id;
            $book_author->author_id  =  $id;
            $book_author->save();
        }

        session()->flash('success', 'A New Book Has Been Created');
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $book = Book::find($id);
        return view('frontend.pages.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
