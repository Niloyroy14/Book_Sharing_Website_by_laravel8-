<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookAuthor;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class AdminBooksController extends Controller
{

    function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        return view('backend.pages.books.index', compact('books'));
    }

    /**
     * unapprove a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unapprove()
    {
        $books = Book::orderBy('id', 'desc')->where('is_approved', 0)->get();
        $approved = false;
        return view('backend.pages.books.index', compact('books', 'approved'));
    }

    /**
     * approve a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approve()
    {
        $books = Book::orderBy('id', 'desc')->where('is_approved', 1)->get();
        $approved = true;
        return view('backend.pages.books.index', compact('books', 'approved'));
    }


    /**
     * approved a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function approved($id)
    {
        $book = Book::find($id);

        if (!is_null($book)) {
            $book->is_approved = 1;
            $book->save();
        }

        session()->flash('success', 'Book Has Been Approved');
        return back();
    }

    /**
     * unapproved a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function unapproved($id)
    {
        $book = Book::find($id);

        if (!is_null($book)) {
            $book->is_approved = 0;
            $book->save();
        }

        session()->flash('success', 'Book Has Been UnApproved');
        return back();
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

        return view('backend.pages.books.create', compact('books', 'categories', 'publishers', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'title'        => 'required|max:50',
                'category_id'  => 'required',
                'publisher_id' => 'required',
                'slug'         => 'nullable|unique:books',
                'description'  => 'nullable',
                'image'        => 'required|image|max:4048',
                'quantity'     => 'required|numeric|min:1'
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
        $book->is_approved  = 1;
        $book->user_id  = 1;
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
        return redirect()->route('admin.books.index');
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

        return view('backend.pages.books.edit', compact('books', 'categories', 'publishers', 'authors', 'book'));
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
                'image'        => 'nullable|image|max:4048',
                'quantity'     => 'required|numeric|min:1'
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
            $book->slug      = $request->slug;
        }
        $book->category_id   = $request->category_id;
        $book->isbn          = $request->isbn;
        $book->quantity      = $request->quantity;
        $book->publisher_id  = $request->publisher_id;
        $book->translator_id = $request->translator_id;
        $book->publish_year  = $request->publish_year;
        $book->description   = $request->description;
        // $book->is_approved  = 1;
        // $book->user_id  = 1;
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
        return redirect()->route('admin.books.index');
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
