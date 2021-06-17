<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'publisher_id',
        'translator_id',
        'title',
        'slug',
        'isbn',
        'publish_year',
        'image',
        'is_approved',
        'user_id',
        'total_view',
        'total_search',
        'total_borrowed',
        'description'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {

        return $this->belongsTo(Category::class);
    }

    public function publisher()
    {

        return $this->belongsTo(Publisher::class);
    }


    public function authors()
    {
        return $this->hasMany(BookAuthor::class);
    }



    public static function isAuthorSelected($book_id, $author_id)
    {

        $book_author = BookAuthor::where('book_id', $book_id)->where('author_id', $author_id)->first();

        if (!is_null($book_author)) {
            return true;
        }
        return false;
    }
}
