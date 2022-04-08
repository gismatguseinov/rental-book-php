@extends('layouts.app')
@section('content')
    @if(count($books) > 0)
        <div class="container-fluid overflow-hidden">
            <div class="row gy-5 mt-0">
                @foreach($books as $book)
                    <div class="card border-1 m-4" style="width: 18rem;">
                        <img style="object-fit: contain;height: 150px;" class="img-thumbnail"
                             src="{{asset($book->cover_image)}}"
                             class="card-img-top" alt="{{$book->title}}">
                        <div class="card-body">
                            <h5 class="card-title"> {{$book->title}}</h5>
                            @foreach($book->genres as $genre)
                                <p class="badge bg-{{$genre->style}}">{{$genre->name}}</p>
                            @endforeach
                            <div class="borrow">
                                <a href="{{route('site.single-book',['id' => $book->id])}}"
                                   class="btn mt-3 btn-outline-success">Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <h1>No added books</h1>
    @endif
@endsection
