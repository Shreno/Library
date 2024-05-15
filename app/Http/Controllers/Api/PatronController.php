<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


use Illuminate\Http\Request;
use App\Models\Patron;

class PatronController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function index()
    {
        $books = Patron::all();
        return response()->json($books);
    }

    public function show($id)
    {
        $book = Patron::find($id);
        return $book ? response()->json($book) : response()->json(['message' => 'Patron not found'], 404);
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email'=>'required|email|unique:patrons',
            'phone'=>'required|numeric|unique:patrons,phone',

           
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else
        {
        $book = Patron::create($request->all());
        return response()->json($book, 201);
        }
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'nullable|string|max:255',
            'email'=>'nullable|email|unique:patrons,email,' .$id . ',id',
            'phone'=>'nullable|numeric|unique:patrons,phone,' .$id . ',id',


        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else
        {
         
    
        $book = Patron::find($id);
        if ($book) {
            $book->update($request->all());
            return response()->json($book);
        } else {
            return response()->json(['message' => 'Patron not found'], 404);
        }
    }
    }

    public function destroy($id)
    {
        $book = Patron::find($id);
        if ($book) {
            $book->delete();
            return response()->json(['message' => 'Patron deleted']);
        } else {
            return response()->json(['message' => 'Patron not found'], 404);
        }
    }
}
