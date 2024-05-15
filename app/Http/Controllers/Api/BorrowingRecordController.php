<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BorrowingRecord;
use App\Models\Patron;

class BorrowingRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function borrow($bookId, $patronId)
    {
        try {
        $book = Book::find($bookId);
        $patron = Patron::find($patronId);
        if (!$book || !$patron) {
            return response()->json(['message' => 'Invalid book or patron ID'], 404);
        }

        $borrowingRecord = new BorrowingRecord([
            'book_id' => $bookId,
            'patron_id' => $patronId,
            'borrowed_date' => now(),
            'returned_date' => null,
        ]);
        $borrowingRecord->save();

        return response()->json($borrowingRecord, 201);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Failed to Borrowing book: ' . $e->getMessage()], 500);
    }
    }

    public function returnBook($bookId, $patronId)
    {
        try {

            $borrowingRecord = BorrowingRecord::where('book_id', $bookId)
                ->where('patron_id', $patronId)
                ->whereNull('returned_date')
                ->first();

            if ($borrowingRecord) {
                $borrowingRecord->returned_date = now();
                $borrowingRecord->save();
                return response()->json(['message' => 'Book returned successfully', 'record' => $borrowingRecord]);
            } else {
                return response()->json(['message' => 'No active borrowing record found for this book and patron'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to return book: ' . $e->getMessage()], 500);
        }
    }
}
