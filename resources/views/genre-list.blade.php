@extends('layouts.app')
@section('content')
    <div class="container mt-2">
        <div class="accordion" id="accordionExample">
            @foreach($genres as $genre)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#{{$genre->style}}"
                                aria-expanded="true" aria-controls="collapseOne">
                            {{$genre->name}}
                        </button>
                    </h2>
                    <div id="{{$genre->style}}" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Author</th>
                                    <th scope="col">Link</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($genre->books as $book)

                                    <tr>
                                        <td>{{$book['book']['title']}}</td>
                                        <td>{{$book['book']['authors']}}</td>
                                        <td><a target="_blank"
                                               href="{{route('site.single-book',['id' => $book['book']['id']])}}">Link</a>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection
