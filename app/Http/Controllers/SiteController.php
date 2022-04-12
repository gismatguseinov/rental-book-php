<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function getBooks()
    {
        $books = Book::all();
        return view('books', compact('books'));
    }

    public function singleBook(int $id)
    {
        $book = Book::findOrFail($id);
        $stock = Borrow::where('book_id', $book->id)->where('status', '<>', 'RETURNED')->count();
        return view('detail-book', compact(['book', 'stock']));
    }

    public function index()
    {
        $userCount = User::where('is_librarian', false)->count();
        $booksCount = Book::all()->count();
        $genreCount = Genre::all()->count();
        $borrows = Borrow::where('status', 'ACCEPTED')->count();
        return view('welcome', compact(['userCount', 'booksCount', 'genreCount', 'borrows']));
    }

    public function borrowBook(int $id): JsonResponse
    {
        ini_set('max_execution_time', 180);
        $readerId = Auth::id();
        $check = Borrow::where('book_id', $id)->where('reader_id', $readerId)->count();
        if ($check > 0) {
            return response()->json([
                'error' => "You can't take this book,because you have a request"
            ], 500);
        }
        $data = Borrow::create([
            'reader_id' => $readerId,
            'book_id' => $id,
            'status' => 'PENDING'
        ]);
        if ($data) {
            return response()->json([
                'status' => true
            ], 201);
        } else {
            return response()->json([
                'msg' => "Error while inserting data to database"
            ], 500);
        }
    }

    public function aboutUs()
    {
        return view('about-us');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    public function myBorrowList()
    {
        $userId = Auth::id();
        $borrowList = Borrow::where('reader_id', $userId)->get();
        foreach ($borrowList as $borrow) {
            $borrow['book_name'] = Book::find($borrow->book_id);
        }
        return view('my-borrows', compact('borrowList'));
    }

    public function search(Request $request)
    {
        if ($request->query != '') {
            $keyword = $request['query'];
            $searchResult = Book::where('title', 'LIKE', '%' . $keyword . '%')->orWhere('author', 'LIKE', '%' . $keyword . '%')->get();
            foreach ($searchResult as $item) {
                $item['genres'] = $item->genres;
            }
            return response()->json($searchResult);
        } else {
            return response()->json([
                'status' => false
            ], 500);
        }
    }

}
