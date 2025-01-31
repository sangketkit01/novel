<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_type extends Model
{
    use HasFactory;

    protected $table = "book_types";
    protected $primaryKey = "bookTypeID";

    function Books()
    {
        return $this->hasMany(Book::class, "bookTypeID");
    }
}
