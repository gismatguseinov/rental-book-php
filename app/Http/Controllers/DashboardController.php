<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::where('is_librarian', false)->count();
        $booksCount = Book::all()->count();
        $genreCount = Genre::all()->count();
        return view('dashboard.dashboard', compact('userCount', 'booksCount', 'genreCount'));
    }

    public function genres()
    {
        $genres = Genre::all();
        return view('dashboard.genres', compact('genres'));
    }

    public function books()
    {
        $genres = Genre::all();
        $books = Book::with('genres')->get();
        return view('dashboard.books', compact(['books', 'genres']));
    }

    public function borrow()
    {
        $borrows = Borrow::where('status', 'PENDING')->get();
        $managedBorrows = Borrow::where('request_managed_by', Auth::id())->where('status', 'ACCEPTED')->get();
        foreach ($borrows as $borrow) {
            $borrow['reader_name'] = User::select('id', 'name')->find($borrow->reader_id);
            $borrow['book_name'] = Book::find($borrow->book_id);
        }
        foreach ($managedBorrows as $borrow) {
            $borrow['reader_name'] = User::select('name')->find($borrow->reader_id);
            $borrow['book_name'] = Book::find($borrow->book_id);
        }
        return view('dashboard.borrow', compact(['borrows', 'managedBorrows']));
    }

    public function returnAndReject()
    {
        $rejected = Borrow::where([
            'status' => 'REJECTED',
            'request_managed_by' => Auth::id()
        ])->get();
        $returned = Borrow::where([
            'status' => 'RETURNED',
            'request_managed_by' => Auth::id()
        ])->get();
        foreach ($rejected as $borrow) {
            $borrow['reader_name'] = User::select('id', 'name')->find($borrow->reader_id);
            $borrow['book_name'] = Book::find($borrow->book_id);
        }
        foreach ($returned as $borrow) {
            $borrow['reader_name'] = User::select('name')->find($borrow->reader_id);
            $borrow['book_name'] = Book::find($borrow->book_id);
        }
        return view('dashboard.borrow-list', compact('rejected', 'returned'));
    }


}
