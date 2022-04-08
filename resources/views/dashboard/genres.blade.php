@extends('dashboard.layouts.app')
@section('content')

    {{--    <form method="post" action="{{route('dashboard.add-genre')}}">--}}
    <form id="addGenre">
        <div class="col-3">
            <label class="form-label" for="genreName">Genre name</label>
            <input type="text" name="genreName" id="name" class="form-control"/>
        </div>
        <div class="col-3">
            <label for="style" class="form-label">Style</label>
            <select id="style" class="form-select">
                <option selected value="">Choose...</option>
                <option value="primary">Primary</option>
                <option value="secondary">Secondary</option>
                <option value="success">Success</option>
                <option value="danger">Danger</option>
                <option value="warning">Warning</option>
                <option value="info">Info</option>
                <option value="dark">Dark</option>
                <option value="light">Light</option>
            </select>
        </div>
        <div class="col-3">
            <button type="submit" class="btn btn-primary btn-block mb-4 mt-5">Add Genre
            </button>
        </div>
    </form>

    <h1>All Genres</h1>
    <div class="col-8">
        <ul class="list-group">
            @if(count($genres) > 0)
                @foreach($genres as $genre)
                    <li class="list-group-item d-flex justify-content-around">
                        <div class="col-4">
                            <span>{{$genre->name}}</span>
                            <span class="">{{$genre->style}}</span>
                        </div>
                        <div class="col-4">
                            <button data-bs-toggle="modal" data-bs-target="#myModal" id="{{$genre->id}}"
                                    class="btn edit btn-primary">Edit
                            </button>
                            <button id="{{$genre->id}}"
                                    class="btn delete btn-danger">Delete
                            </button>
                        </div>
                    </li>
                @endforeach
            @else
                <div class="container-fluid">
                    <div>
                        <span style="text-align: center">No genre added</span>
                    </div>
                </div>
            @endif
        </ul>
    </div>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Enter deadline</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <input type="text" name="updateGenreName" id="updateGenreName" class="form-control">
                    <br>
                    <select name="updateStyle" id="updateStyle" class="form-select">
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                        <option value="success">Success</option>
                        <option value="danger">Danger</option>
                        <option value="warning">Warning</option>
                        <option value="info">Info</option>
                        <option value="dark">Dark</option>
                        <option value="light">Light</option>
                    </select>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-success update" data-bs-dismiss="modal">Update</button>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#addGenre').on('submit', function (e) {
            e.preventDefault()
            let genreName = $('input[name=genreName]').val()
            let genreStyle = $('#style').val()
            $.ajax({
                url: "{{route('dashboard.add-genre')}}",
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    name: genreName,
                    style: genreStyle
                },
                success: function (response) {
                    if (response.status === true) {
                        window.location.replace('{{route('dashboard.genres')}}')
                    }
                },
                error: function (response) {
                    console.log(response)
                },
            });
        })

        $('.edit').on('click', function () {
            let id = this.id;
            let url = '{{route('dashboard.single-genre',':id')}}'
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'GET',
                success: function (response) {
                    $('#updateGenreName').val(response.name)
                    $('.update').attr('id', response.id)
                    let str = response.style
                    let result = str.replace(/\b\w/g, x => x.toUpperCase());
                    $('#updateStyle').append(`<option selected value="${response.style}">
                                       ${result}
                                  </option>`);
                },
                error: function (err) {
                    console.log(err)
                }
            })
        });

        $('.update').on('click', function () {
            let id = this.id;
            let url = '{{route('dashboard.update-genre',':id')}}'
            url = url.replace(':id', id);
            let updateGenreName = $('input[name=updateGenreName]').val()
            let updateGenreStyle = $('#updateStyle').val()
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    updateGenreName: updateGenreName,
                    updateGenreStyle: updateGenreStyle
                },
                success: function (response) {
                    if (response.status === true) {
                        window.location.replace('{{route('dashboard.genres')}}')
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })

        $('.delete').on('click', function () {
            let id = this.id;
            let url = '{{route('dashboard.delete-genre',':id')}}'
            url = url.replace(':id', id);
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                },
                success: function (response) {
                    if (response.status === true) {
                        window.location.replace('{{route('dashboard.genres')}}')
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        })

    </script>

@endsection


