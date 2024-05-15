<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
  
    public function index()
    {
        $user=auth()->user();
        $books = Book::all();
        return response()->json($books);
    }
    public function show($id)
    {
        $book = Book::find($id);
        return $book ? response()->json($book) : response()->json(['message' => 'Book not found'], 404);
    }

    public function store(Request $request)
    {

        $rules = [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:1900|max:' . date('Y'),
            'isbn' => 'required|string|unique:books,isbn'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else
        {
            $book = Book::create($request->all());
            return response()->json($book, 201);



        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'publication_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'isbn' => 'nullable|string|unique:books,isbn,' .$id . ',id',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else
        {

        }

        $book = Book::find($id);
        if ($book) {
            $book->update($request->all());
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }

    public function destroy($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
            return response()->json(['message' => 'Book deleted']);
        } else {
            return response()->json(['message' => 'Book not found'], 404);
        }
    }
}
