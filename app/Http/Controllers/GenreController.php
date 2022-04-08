<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenreRequest;
use App\Models\Genre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{
    public function addGenre(GenreRequest $genreRequest)
    {
        ini_set('max_execution_time', 180);
        $validated = $genreRequest->validated();
        $data = DB::table('genres')->insert([
            'name' => $validated['name'],
            'style' => $validated['style'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        return response()->json([
            'status' => true
        ], 201);
    }

    public function singleGenre(int $id)
    {
        $genre = Genre::findOrFail($id);
        return response()->json($genre);
    }

    public function delete(int $id)
    {
        $genre = Genre::findOrFail($id);
        $genre?->delete();
        DB::table('book_genre')->where('genre_id', $id)->delete();
        return response()->json([
            'status' => true
        ], 200);
    }

    public function update(int $id, Request $request)
    {
        $genre = Genre::findOrFail($id);
        $genre?->update([
            'name' => $request->updateGenreName,
            'style' => $request->updateGenreStyle
        ]);
        return response()->json([
            'status' => true
        ]);
    }
}
