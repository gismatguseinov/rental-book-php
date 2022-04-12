@extends('dashboard.layouts.app')
@section('content')

    <form id="addBook" class="row g-3" data-action="{{ route('dashboard.add-book') }}" method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="col-md-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title">
        </div>
        <div class="col-md-3">
            <label for="authors" class="form-label">Authors</label>
            <input type="text" name="authors" class="form-control" id="authors">
        </div>
        <div class="col-3">
            <label for="released_at" class="form-label">Released at</label>
            <input type="date" name="released_at" class="form-control" id="released_at"/>
        </div>
        <div class="col-3">
            <label for="pages" class="form-label">Pages</label>
            <input type="number" name="pages" class="form-control" id="pages">
        </div>
        <div class="col-4">
            <label for="genres[]" class="form-label">Genre</label>
            <select class="form-control" id="genres" name="genres[]" multiple="multiple">
                @foreach($genres as $genre)
                    <option value="{{$genre->id}}">{{$genre->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-8">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" rows="4" name="description" cols="50" class="form-control"
                      id="description"></textarea>
        </div>
        <div class="col-md-4">
            <label for="language_code" class="form-label">Language Code</label>
            <select id="language_code" name="language_code" class="form-select">
                <option selected value="hu">HU</option>
                <option value="en">EN</option>
                <option value="ru">RU</option>
            </select>
        </div>
        <div class="col-md-2">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" name="isbn" id="isbn">
        </div>
        <div class="col-md-2">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" name="in_stock" id="stock">
        </div>
        <div class="col-3">
            <label class="form-label" for="coverImage">Cover Image</label>
            <input type="file" class="form-control" name="cover_image" id="coverImage"/>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Book</button>
        </div>
    </form>

    <h1 class="pt-5">All Books</h1>
    <div class="container-fluid">

        @if(count($books) > 0)
            <div class="row">
                @foreach($books as $book)

                    <div class="col">
                        <div class="col-8 image">
                            <img src="{{asset($book->cover_image)}}" width="100" height="100" alt="">
                        </div>
                        {{--                        {{route('dashboard.destroy-book',$book->id)}}--}}
                        <div class="col-6 descr">
                            <p>Title:{{$book->title}}</p>
                            <p>Authors:{{$book->authors}}</p>
                            <a class="btn btn-sm btn-success"
                               href="{{route('dashboard.single-book',$book->id)}}">Edit</a>
                            <button id="{{$book->id}}" class="btn btn-sm deleteBook btn-warning">Delete</button>
                        </div>
                        <div class="col-8 genres">
                            @foreach($book->genres as $genre)
                                <span class="badge bg-{{$genre->style}}">{{$genre->name}}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

        @else
            <div class="container-fluid">
                <div>
                    <span style="text-align: center">No book added</span>
                </div>
            </div>
        @endif
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#addBook').on('submit', function (event) {
                event.preventDefault();
                let formData = new FormData(this)
                let url = $('#addBook').attr('data-action');
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        if (response.status === true) {
                            $.notify({
                                title: "<strong>Info</strong>",
                                message: "Successfully Added"
                            }, {
                                animate: {
                                    enter: "animate fadeInUp",
                                    exit: "animate fadeOutDown"
                                }
                            })
                            setInterval(window.location.replace('{{route('dashboard.books')}}'), 2500)

                        }
                    },
                    error: function (err) {
                        let value = $.parseJSON(err.responseText);
                        $.notify({
                            title: "<strong>Error</strong>",
                            message: value.message
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }, type: 'danger'
                        })
                    }
                });
            });

            $('.deleteBook').on('click', function () {
                let id = this.id;
                let url = '{{route('dashboard.destroy-book',':id')}}'
                url = url.replace(':id', id);
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                    },
                    success: function (response) {
                        if (response.status === true) {
                            $.notify({
                                title: "<strong>Info</strong>",
                                message: "Delete"
                            }, {
                                animate: {
                                    enter: "animate fadeInUp",
                                    exit: "animate fadeOutDown"
                                }
                            })
                            setInterval(window.location.replace('{{route('dashboard.books')}}'), 2500)
                        }
                    },
                    error: function (err) {
                        let value = $.parseJSON(err.responseText);
                        $.notify({
                            title: "<strong>Error</strong>",
                            message: value.err
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }, type: 'danger'
                        })
                    }
                })
            });
        })
    </script>
@endsection
