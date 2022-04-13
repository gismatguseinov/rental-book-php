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
    <table class="table table-hover table-sm">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Style</th>
            <th scope="col">Actions</th>
        </tr>
        </thead>
        <tbody>
        @if(count($genres) > 0)
            @foreach($genres as $genre)
                <tr>
                    <th scope="row">{{$genre->id}}</th>
                    <td>{{$genre->name}}</td>
                    <td>{{$genre->style}}</td>
                    <td>
                        <div class="col-4">
                            <button data-bs-toggle="modal" data-bs-target="#myModal" id="{{$genre->id}}"
                                    class="btn btn-sm edit btn-primary">Edit
                            </button>
                            <button id="{{$genre->id}}"
                                    class="btn btn-sm delete btn-danger">Delete
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <th>Data Not found</th>
            </tr>
        @endif
        </tbody>
    </table>

    <div class="modal" id="myModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Genre</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <!-- Modal body -->
                <div class="modal-body p-4">
                    <input type="text" name="updateGenreName" id="updateGenreName" class="form-control">
                    <br>
                    <select name="updateStyle" id="updateStyle" class="form-select">
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
                        $.notify({
                            title: "<strong>Info</strong>",
                            message: "Successfully Accepted"
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }
                        })
                        setInterval(window.location.replace('{{route('dashboard.genres')}}'), 2000)
                    }
                },
                error: function (response) {
                    let value = $.parseJSON(response.responseText);
                    console.log(value)
                    $.notify({
                        title: "<strong>Error</strong>",
                        message: value.message
                    }, {
                        animate: {
                            enter: "animate fadeInUp",
                            exit: "animate fadeOutDown"
                        }, type: 'danger'
                    })
                },
            });
        })

        $('.edit').on('click', function () {
            let genreList = {
                primary: 'Primary',
                secondary: 'Secondary',
                success: 'Success',
                danger: 'Danger',
                warning: 'Warning',
                info: 'Info',
                dark: 'Dark',
                light: 'Light',
            }

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
                    $.each()
                    for (const [key, value] of Object.entries(genreList)) {
                        if (value == result) {
                            $('#updateStyle').append(`<option selected value="${response.style}">
                                       ${result}
                                  </option>`);
                        } else {
                            $('#updateStyle').append(`<option value="${key}">
                                       ${value}
                                  </option>`);
                        }
                    }

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
                        $('#updateStyle').empty()
                        $.notify({
                            title: "<strong>Info</strong>",
                            message: "Successfully Accepted"
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }
                        })
                        setInterval(window.location.replace('{{route('dashboard.genres')}}'), 2000)
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
                        $.notify({
                            title: "<strong>Info</strong>",
                            message: "Successfully Deleted"
                        }, {
                            animate: {
                                enter: "animate fadeInUp",
                                exit: "animate fadeOutDown"
                            }
                        })
                        setInterval(window.location.replace('{{route('dashboard.genres')}}'), 2000)
                    }
                },
                error: function (err) {
                    let value = $.parseJSON(err.responseText);
                    console.log(value)
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
            })
        })

    </script>

@endsection


