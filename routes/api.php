<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\PatronController;
use App\Http\Controllers\Api\AuthController;


use App\Http\Controllers\Api\BorrowingRecordController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/login', [AuthController::class, 'login']);





// Book management routes
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::post('/books', [BookController::class, 'store']);
Route::put('/books/{id}', [BookController::class, 'update']);
Route::delete('/books/{id}', [BookController::class, 'destroy']);

// Patron management routes
Route::get('/patrons', [PatronController::class, 'index']);
Route::get('/patrons/{id}', [PatronController::class, 'show']);
Route::post('/patrons', [PatronController::class, 'store']);
Route::put('/patrons/{id}', [PatronController::class, 'update']);
Route::delete('/patrons/{id}', [PatronController::class, 'destroy']);

// Borrowing endpoint
Route::post('/borrow/{bookId}/patron/{patronId}', [BorrowingRecordController::class, 'borrow']);
Route::post('/return/{bookId}/patron/{patronId}', [BorrowingRecordController::class, 'returnBook']);


























