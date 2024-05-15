<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patron extends Model
{
    protected $fillable = ['name', 'email','phone'];

    public function borrowingRecords()
    {
        return $this->hasMany(BorrowingRecord::class);
    }
}
