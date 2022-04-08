@extends('dashboard.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-3">
                <div class="col-8 ">
                    <span style="font-size: 30px">Users</span>
                </div>
                <div class="col-4">
                    <span style="font-size: 25px">{{$userCount}}</span>
                </div>
            </div>
            <dov class="col-3">
                <div class="col-8 ">
                    <span style="font-size: 30px">Genres</span>
                </div>
                <div class="col-4">
                    <span style="font-size: 25px">{{$genreCount}}</span>
                </div>
            </dov>
            <div class="col-3">
                <div class="col-8 ">
                    <span style="font-size: 30px">Books</span>
                </div>
                <div class="col-4">
                    <span style="font-size: 25px">{{$booksCount}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
