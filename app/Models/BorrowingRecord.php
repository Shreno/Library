<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowingRecord extends Model
{
    protected $fillable = ['book_id', 'patron_id', 'borrowed_date', 'returned_date'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class);
    }
}
