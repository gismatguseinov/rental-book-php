@extends('layouts.app')
@section('content')
    <div style="width: 90%;margin-left: 5%;height: auto">
        <div class="container bg-light d-flex">
            <div class="col-6">
                <div class="col-10 m-lg-5">
                    <img style="width: auto;height: 80vh;" src="{{$book->cover_image}}" alt="">
                </div>
            </div>
            <div class="col-6 pt-5">
                <div class="content mb-5">
                    <div class="title mb-2">
                        <h1 style="font-size: 24px">{{$book->title}}</h1>
                    </div>
                    <div class="authors mb-4">
                        <h1 style="font-size: 18px">{{$book->authors}}</h1>
                    </div>
                    <div class="description mb-4">
                        <hr>
                        <p>Description</p>
                        <p>{{$book->description}}</p>
                        <hr>
                    </div>
                </div>
                <div class="another-content">
                    <div class="rd col-8 d-flex justify-content-around">
                        <p>Released date</p>
                        <p>{{date('d-m-Y', strtotime($book->released_at))}}</p>
                    </div>
                    <div class="isbn col-8 d-flex justify-content-around">
                        <p>ISBN number</p>
                        <p>{{$book->isbn}}</p>
                    </div>
                    <div class="stock col-8 d-flex justify-content-around">
                        <p>Stock</p>
                        <p>{{$book->in_stock - $stock}}</p>
                    </div>
                    <div class="pages col-8 d-flex justify-content-around">
                        <p>Pages</p>
                        <p> {{$book->pages}}</p>
                    </div>
                    <div class="lc col-8 d-flex justify-content-around">
                        <p>Language Code</p>
                        @if($book->language_code=='en')
                            {{$lgCode = 'English'}}
                        @elseif($book->language_code == 'hu')
                            {{$lgCode = 'Hungry'}}
                        @else
                            {{$lgCode = 'Russian'}}
                        @endif
                    </div>
                    <hr>
                </div>
                <div class="bagdes">
                    <p>Genres</p>
                    @foreach($book->genres as $genre)
                        <p style="font-size: 16px" class="badge bg-{{$genre->style}}">{{$genre->name}}</p>
                    @endforeach
                </div>
                <div class="col-4">
                    <button onclick="borrow()" class="btn btn-lg btn-outline-danger">Borrow this book</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function borrow() {
            $.ajax({
                url: "{{route('site.borrow-book',['id'=>$book->id])}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === true) {
                        $.notify({
                            title: "<strong>Info</strong>",
                            message: "Borrow request successfully sent"
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }
                        })
                    }
                },
                error: function (err) {
                    let error = err.responseText.split(':')[1];
                    let errorMessage = error.replace('}', '').replaceAll('"', '')
                    $.notify({
                        title: "<strong>Error</strong>",
                        message: errorMessage
                    }, {
                        animate: {
                            enter: "animate fadeInUp",
                            exit: "animate fadeOutDown"
                        }, type: 'danger'
                    })
                },
            });
        }
    </script>
@endsection
