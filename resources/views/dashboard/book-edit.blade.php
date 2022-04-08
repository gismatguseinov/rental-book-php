@extends('dashboard.layouts.app')
@section('content')
    <form id="updateBook" class="row g-3" data-action="{{ route('dashboard.update-book',['id' => $book['id']]) }}"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        <div class="col-md-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{$book['title']}}" id="title">
        </div>
        <div class="col-md-3">
            <label for="authors" class="form-label">Authors</label>
            <input type="text" name="authors" class="form-control" value="{{$book['authors']}}" id="authors">
        </div>
        <div class="col-3">
            <label for="released_at" class="form-label">Released at</label>
            <input type="date" name="released_at" value="{{explode(" ",$book['released_at'])[0]}}"
                   class="form-control" id="released_at"/>
        </div>
        <div class="col-3">
            <label for="pages" class="form-label">Pages</label>
            <input type="number" name="pages" value="{{$book['pages']}}" class="form-control" id="pages">
        </div>
        <div class="col-4">
            <label for="genres[]" class="form-label">Genre</label>
            <select class="form-control" id="genres" name="genres[]" multiple="multiple">
                @foreach($allGenres as $genre)
                    @foreach($book->genres as $bookGenre)
                        @if($genre->name === $bookGenre->name)
                            <option selected value="{{$genre->style}}">{{$genre->name}}</option>
                        @else
                            <option value="{{$genre->style}}">{{$genre->name}}</option>
                        @endif
                    @endforeach
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label for="language_code" class="form-label">Language Code</label>
            <select id="language_code" name="language_code" class="form-select">
                @if($book->language_code === 'hu')
                    <option selected value="hu">HU</option>
                    <option value="en">EN</option>
                    <option value="ru">RU</option>
                @endif
                @if($book->language_code === 'en')
                    <option value="hu">HU</option>
                    <option selected value="en">EN</option>
                    <option value="ru">RU</option>
                @endif
                @if($book->language_code === 'ru')
                    <option value="hu">HU</option>
                    <option value="en">EN</option>
                    <option selected value="ru">RU</optionselected>
                @endif


            </select>
        </div>
        <div class="col-md-2">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control" readonly value="{{$book['isbn']}}" name="isbn" id="isbn">
        </div>
        <div class="col-md-2">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control" value="{{$book['in_stock']}}" name="in_stock" id="stock">
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Description</label>
            <textarea type="text" rows="4" name="description" cols="50" class="form-control"
                      id="description">{{$book['description']}}</textarea>
        </div>
        <div class="col-lg-12">
            <div class="col-4">
                <label class="form-label" for="coverImage">Cover Image</label>
                <input type="file" class="form-control" name="cover_image" id="coverImage"/>
            </div>
            <div col-8>
                <img style="width: 100px;height:150px" src="{{asset($book['cover_image'])}}" alt="">
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Book</button>
        </div>
    </form>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#updateBook').on('submit', function (event) {
                event.preventDefault();
                let formData = new FormData(this)
                let url = $('#updateBook').attr('data-action');
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
                            window.location.replace('{{route('dashboard.books')}}')
                        }
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
            });
        })
    </script>
@endsection
