<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\BooksController;
use App\Http\Controllers\Frontend\UsersController;
use App\Http\Controllers\Frontend\DashboardsController;
use App\Http\Controllers\Auth\Admin\LoginController;
use App\Http\Controllers\Auth\Admin\RegisterController;

use App\Http\Controllers\Backend\AdminPagesController;
use App\Http\Controllers\Backend\AdminBooksController;
use App\Http\Controllers\Backend\AdminAuthorsController;
use App\Http\Controllers\Backend\AdminCategoryController;
use App\Http\Controllers\Backend\AdminPublishersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// });



Route::get('/', [PagesController::class, 'index'])->name('index');

/*Books Route*/

Route::get('/books/show/{id}',      [BooksController::class, 'show'])->name('books.show');
Route::get('/books',                [BooksController::class, 'index'])->name('books.index');
Route::get('/books/search',         [BooksController::class, 'search'])->name('books.search');
Route::post('/books/advance-search', [BooksController::class, 'advanceSearch'])->name('books.search.advance');
Route::get('/book/upload',          [BooksController::class, 'create'])->name('books.upload');
Route::post('/book/store',          [BooksController::class, 'store'])->name('books.store');



/*users profile Route*/

Route::prefix('user')->group(function () {
   Route::get('/profile/{username}',       [UsersController::class, 'show'])->name('users.profile');
   Route::get('/profile/{username}/books', [UsersController::class, 'books'])->name('users.books');
});


/*users dashboard Route*/

Route::prefix('dashboard')->group(function () {
   Route::get('/',                           [DashboardsController::class, 'index'])->name('users.dashboards');
   Route::get('/books',                      [DashboardsController::class, 'books'])->name('users.dashboards.books');
   Route::get('/books/edit/{id}',            [DashboardsController::class,  'edit'])->name('users.dashboards.books.edit');
   Route::post('/books/update/{id}',         [DashboardsController::class,  'update'])->name('users.dashboards.books.update');
   Route::post('/books/delete/{id}',         [DashboardsController::class,  'destroy'])->name('users.dashboards.books.delete');
   Route::post('/books/request/{id}',        [DashboardsController::class,  'requestBook'])->name('books.request');
   Route::post('/books/request/update/{id}', [DashboardsController::class,  'requestUpdateBook'])->name('books.request.update');
   Route::post('/books/request/delete/{id}', [DashboardsController::class,  'requestdeleteBook'])->name('books.request.delete');
   Route::get('/books/request_list',         [DashboardsController::class,  'requestBookList'])->name('books.request.list');
   Route::post('/books/request/approve/{id}', [DashboardsController::class, 'requestBookApprove'])->name('books.request.approve');
   Route::post('/books/request/reject/{id}', [DashboardsController::class, 'requestBookReject'])->name('books.request.reject');

   //orders Route

   Route::get('/books/order_list',            [DashboardsController::class,  'orderBookList'])->name('books.order.list');
   Route::post('/books/order/approve/{id}',   [DashboardsController::class, 'orderBookApprove'])->name('books.order.approve');
   Route::post('/books/order/reject/{id}',    [DashboardsController::class, 'orderBookReject'])->name('books.order.reject');

   //return order

   Route::post('/books/order/return/{id}',            [DashboardsController::class, 'orderBookReturn'])->name('books.return.store');
   Route::post('/books/order/return_confirm/{id}',    [DashboardsController::class, 'orderBookReturnConfirm'])->name('books.return.confirm');
});



/*Books Category Route*/

Route::get('/books/category/{slug}',    [CategoryController::class, 'show'])->name('categories.show');





/*Admin Route*/


Route::prefix('admin')->group(function () {

   /*authentication*/

   Route::get('/login',            [LoginController::class, 'showLoginForm'])->name('admin.login');
   Route::post('/login/submit',    [LoginController::class, 'login'])->name('admin.login.submit');
   Route::post('/logout/submit',   [LoginController::class, 'logout'])->name('admin.logout');

   Route::get('/dashboard', [AdminPagesController::class, 'index'])->name('admin.index');

   /*books*/

   Route::prefix('books')->group(function () {
      Route::get('/',                 [AdminBooksController::class, 'index'])->name('admin.books.index');
      Route::get('/create',           [AdminBooksController::class, 'create'])->name('admin.books.create');
      Route::post('/store',           [AdminBooksController::class, 'store'])->name('admin.books.store');
      Route::get('/edit/{id}',        [AdminBooksController::class, 'edit'])->name('admin.books.edit');
      Route::post('/update/{id}',     [AdminBooksController::class, 'update'])->name('admin.books.update');
      Route::post('/delete/{id}',     [AdminBooksController::class, 'destroy'])->name('admin.books.delete');
      Route::get('/unapprove',        [AdminBooksController::class, 'unapprove'])->name('admin.books.unapprove');
      Route::get('/approve',          [AdminBooksController::class, 'approve'])->name('admin.books.approve');
      Route::post('/approved/{id}',   [AdminBooksController::class, 'approved'])->name('admin.books.approved');
      Route::post('/unapproved/{id}', [AdminBooksController::class, 'unapproved'])->name('admin.books.unapproved');
   });

   /*authors*/

   Route::prefix('authors')->group(function () {
      Route::get('/',             [AdminAuthorsController::class, 'index'])->name('admin.authors.index');
      Route::post('/store',       [AdminAuthorsController::class, 'store'])->name('admin.authors.store');
      Route::get('/show/{id}',    [AdminAuthorsController::class, 'show'])->name('admin.authors.show');
      Route::post('/update/{id}', [AdminAuthorsController::class, 'update'])->name('admin.authors.update');
      Route::post('/delete/{id}', [AdminAuthorsController::class, 'destroy'])->name('admin.authors.delete');
   });


   /*categories*/

   Route::prefix('categories')->group(function () {
      Route::get('/',             [AdminCategoryController::class, 'index'])->name('admin.category.index');
      Route::post('/store',       [AdminCategoryController::class, 'store'])->name('admin.category.store');
      Route::get('/show/{id}',    [AdminCategoryController::class, 'show'])->name('admin.category.show');
      Route::get('/edit/{id}',    [AdminCategoryController::class, 'edit'])->name('admin.category.edit');
      Route::post('/update/{id}', [AdminCategoryController::class, 'update'])->name('admin.category.update');
      Route::post('/delete/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.category.delete');
   });



   /*publishers*/

   Route::prefix('publishers')->group(function () {
      Route::get('/',             [AdminPublishersController::class, 'index'])->name('admin.publishers.index');
      Route::post('/store',       [AdminPublishersController::class, 'store'])->name('admin.publishers.store');
      Route::get('/show/{id}',    [AdminPublishersController::class, 'show'])->name('admin.publishers.show');
      Route::get('/edit/{id}',    [AdminPublishersController::class, 'edit'])->name('admin.publishers.edit');
      Route::post('/update/{id}', [AdminPublishersController::class, 'update'])->name('admin.publishers.update');
      Route::post('/delete/{id}', [AdminPublishersController::class, 'destroy'])->name('admin.publishers.delete');
   });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
