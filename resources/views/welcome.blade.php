@extends('layouts.app')
@section('content')
    <div class="container-fluid"
         style="background: url({{asset('background.webp')}});background-repeat: no-repeat;height: 100vh">


        <div class="searchcontainer d-flex justify-content-center align-items-center">
            <form class="d-flex container" style="margin-top: 10%;" id="searchBook"
                  data-action="{{ route('site.search') }}" method="GET">
                <input style="width: 60%;height: 50px;" class="form-control me-2" name="query"
                       type="search" id="query"
                       placeholder="Search by Title,Author"
                       aria-label="Search">
                <button class="btn btn-lg search btn-primary" type="submit">Find Books
                </button>
            </form>
        </div>

        <div class="container info" style="margin-top: 25rem !important;">
            <div class="row">
                <div class="col-md-3">
                    <div class="card p-3 mb-2">
                        <div class="d-flex justify-content-between">

                        </div>
                        <div class="mt-5">
                            <h3 class="heading">Book Count<br>{{$booksCount}}</h3>
                            <div class="mt-5">
                                <div class="progress">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 mb-2">
                        <div class="d-flex justify-content-between">

                        </div>
                        <div class="mt-5">
                            <h3 class="heading">User Count<br>{{$userCount}}</h3>
                            <div class="mt-5">
                                <div class="progress">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 mb-2">
                        <div class="d-flex justify-content-between">

                        </div>
                        <div class="mt-5">
                            <h3 class="heading">Borrow Count<br>{{$borrows}}</h3>
                            <div class="mt-5">
                                <div class="progress">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3 mb-2">
                        <div class="d-flex justify-content-between">

                        </div>
                        <div class="mt-5">
                            <h3 class="heading">Genre Count<br>{{$genreCount}}</h3>
                            <div class="mt-5">
                                <div class="progress">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="searchDiv" class="container-fluid">
            <h1 style="display: none;text-align: center" id="searchResultData">Search Result</h1>
            <div id="searchDivResult" class="row">

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#searchBook').on('submit', function (event) {
                event.preventDefault();
                $('#searchDivResult').empty()
                let query = $('#query').val()
                if (query === '') {
                    $.notify({
                        title: "<strong>Error</strong>",
                        message: 'Search field must not empty'
                    }, {
                        animate: {
                            enter: "animate fadeInUp",
                            exit: "animate fadeOutDown"
                        }, type: 'danger'
                    })
                    return
                }
                let url = $('#searchBook').attr('data-action');
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        query: query
                    },
                    success: function (response) {
                        if (response.length > 0) {
                            response.forEach(function (result) {
                                    let dataUrl = '{{route('site.single-book',':id')}}'
                                    dataUrl = dataUrl.replace(':id', result.id)
                                    let coverImage = '{{asset(':imageUrl')}}'
                                    result.cover_image = result.cover_image.replace('/', '')
                                    coverImage = coverImage.replace(':imageUrl', result.cover_image)
                                    let searchResultData = {
                                        'display': 'block',
                                    }
                                    $('#searchResultData').css(searchResultData)
                                    let info = {
                                        'display': 'none'
                                    }
                                    $('.info').css(info)
                                    $('#query').val('')
                                    let searchDiv = {
                                        'margin-top': '23rem'
                                    }
                                    $('#searchDiv').css(searchDiv)
                                    $('#searchDivResult').append(
                                        `
                                    <div class="card mx-lg-5 mb-5" style="width: 16rem;">
                                            <img src="${coverImage}" style="width: auto;height: 240px"
                                                 class="card-img-top" alt="${result.title}">
                                            <div class="card-body">
                                                <h5 class="card-title">${result.title}</h5>
                                                <h5 class="card-title">${result.authors}</h5>
                                    <div class="borrow">
                                        <a target="_blank" href="${dataUrl}"
                                                       class="btn mt-3 btn-outline-success">Details</a>
                                                </div>
                                            </div>
                                        </div>
                            `
                                    )
                                }
                            )
                        } else {
                            $('.info').css('display', 'none')
                            $('#searchDivResult').append(`<h1 style="text-align: center"> No data found</h1>`)
                        }
                    },
                    error: function (err) {
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
                    }
                });
            });
        })
    </script>

@endsection


