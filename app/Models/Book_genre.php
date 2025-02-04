<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_genre extends Model
{
    use HasFactory;

    protected $table = "book_genres";
    protected $primaryKey = "bookGenreID";

    function Books(){
        return $this->hasMany(Book::class,"bookGenreID");
    }
}
